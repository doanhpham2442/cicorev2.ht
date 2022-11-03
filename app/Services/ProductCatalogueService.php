<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;
use App\Libraries\Nestedsetbie;


class ProductCatalogueService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $model;
	protected $nestedsetbie;
   protected $pagination;
   protected $productCatalogueRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');

      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => $this->module, 'language' => $this->language, 'foreignkey' => 'product_catalogue_id']
      );
      $this->productCatalogueRepository = service('ProductCatalogueRepository', $this->module);
      $this->routerRepository = service('routerRepository', 'routers');
   }




   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();

      $config['total_rows'] = $this->productCatalogueRepository->count($condition, $keyword);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.product.catalogue.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$productCatalogue = $this->productCatalogueRepository->paginate($condition, $keyword, $config, $page);
		}

      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($productCatalogue) ?? '',
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = $this->request();
         $id = $this->productCatalogueRepository->create($payload);
         if($id > 0){
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['product_catalogue_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);
            $translateID = $this->productCatalogueRepository->createTranslate($payloadTranslate, 'product_catalogue_translate');
            $payloadRouters = router('Product','Catalogue', $id, $this->module, $this->language, $payloadTranslate['canonical']);
            $routerID = $this->routerRepository->create($payloadRouters);
            $this->nestedsetbie();
         }

         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function update($id){
      $this->db->transBegin();
      try{
         $payload = $this->request();
         $flag = $this->productCatalogueRepository->update($payload, $id);

         if($flag > 0){
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['product_catalogue_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);
            $flagTranslate = $this->productCatalogueRepository->updateTranslate($payloadTranslate, 'product_catalogue_translate', ['product_catalogue_id' => $id, 'language_id' => $this->language]);

            $this->routerRepository->deleteRouter($id, $this->module);
            $payloadRouters = router('Product','Catalogue', $id, $this->module, $this->language, $payloadTranslate['canonical']);
            $routerID = $this->routerRepository->create($payloadRouters);
            $this->nestedsetbie();

         }
         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         dd($e);
         return false;
      }
   }

   public function delete($id, $productCatalogue){
      $id = (int)$id;

      try{
         /* Xóa danh mục */
         /* Tìm danh mục con bao gồm cả danh mục đang muốn xóa */
         $childrenNode = $this->productCatalogueRepository->getChildNode($productCatalogue['lft'], $productCatalogue['rgt']);
         $listID = [];
         foreach($childrenNode as $key => $val){
            $listID[] = $val['id'];
         }
         /*
            Xóa router và xóa danh mục
         */
         if(isset($listID) && is_array($listID) && count($listID)){
            foreach($listID as $key => $val){
               $this->routerRepository->deleteRouter($val, $this->module);
               $this->productCatalogueRepository->softDelete($val);
            }
         }
         $this->nestedsetbie();
         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         dd($e);
         return false;
      }

   }


   private function request(){
      $payload = requestAccept(['parentid','image', 'icon','album','publish'], Auth::id());
      return $payload;
   }

   private function nestedsetbie(){
      $this->nestedsetbie->Get('level ASC, order ASC');
      $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
      $this->nestedsetbie->Action();
   }

   private function condition(){
      $condition = [];
      if($this->request->getGet('publish')){
         $condition['tb1.publish'] = $this->request->getGet('publish');
      }
      $condition['tb1.deleted_at'] = 0;
      $condition['tb2.language_id'] = $this->language;

      return $condition;
   }

   private function keyword(): string{
      $search = '';
      if(!empty($this->request->getGet('keyword'))){
         $fieldSearch = ['title','description'];

         $keyword = $this->request->getGet('keyword');
         if(isset($fieldSearch) && is_array($fieldSearch) && count($fieldSearch)){
            foreach($fieldSearch as $key => $val){
               if(empty($search)){
                  $search = '(tb2.'.$val.' LIKE \'%'.$keyword.'%\')';
               }else{
                  $search = $search.' OR '.'(tb2.'.$val.' LIKE \'%'.$keyword.'%\')';
               }

            }
         }
      }
      return $search;
   }

}
