<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class PromotionService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $model;
	protected $nestedsetbie;
   protected $pagination;
   protected $promotionRepository;
   protected $promotionCatalogueRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->promotionRepository = service('PromotionRepository', $this->module);
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->productRepository = service('ProductRepository', 'products');
      $this->routerRepository = service('routerRepository', 'routers');
   }

   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();

      $config['total_rows'] = $this->promotionRepository->count($condition, $keyword);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.promotion.promotion.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$promotionCatalogue = $this->promotionRepository->paginate($condition, $keyword, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($promotionCatalogue) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = requestExcerpt(['original_canonical','save'], Auth::id());
         $payload['discount_value'] = str_replace('.','', $payload['discount_value']);
         $payload['object_id'] = json_encode($payload['object_id']);
         $payload['canonical'] = slug($payload['canonical']);
         $id = $this->promotionRepository->create($payload);
         if($id > 0){
            //Xử lý Relation giữa sản phẩm và khuyến mãi
            $relation = $this->relation($payload['module'], $id);
            $this->promotionRepository->createBatch($relation, 'promotion_product');


            $payloadRouters = router('Marketing','Promotion', $id, $this->module, $this->language, $payload['canonical']);
            $routerID = $this->routerRepository->create($payloadRouters);
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
         $payload = requestExcerpt(['original_canonical','save'], Auth::id());
         $payload['discount_value'] = (float)str_replace('.','', $payload['discount_value']);
         $payload['object_id'] = json_encode($payload['object_id']);
         $payload['canonical'] = slug($payload['canonical']);
         $flag = $this->promotionRepository->update($payload, $id);
         if($flag > 0){

            //Xử lý Relation giữa sản phẩm và khuyến mãi
            $relation = $this->relation($payload['module'], $id);
            $this->promotionRepository->deleteRelation($id, 'promotion_product', 'promotion_id');
            $this->promotionRepository->createBatch($relation, 'promotion_product');

            $payloadRouters = router('Marketing','Promotion', $id, $this->module, $this->language, $payload['canonical']);
            $this->routerRepository->deleteRouter($id, $this->module);
            $routerID = $this->routerRepository->create($payloadRouters);

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

   public function delete($id){
      $id = (int)$id;
      try{
         /* Xóa bản ghi - xóa router - xóa relation */
         $this->promotionRepository->softDelete($id);
         $this->routerRepository->deleteRouter($id, $this->module);
         $this->promotionRepository->deleteRelation($id, 'promotion_product', 'promotion_id');

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


   private function relation($module, $id){
      $object_id = $this->request->getPost('object_id');
      $module = (string)$module;
      $id = (int)$id;

      switch ($module) {
         case 'products':
            $relation = $this->handleProduct($object_id, $id);
            break;
         case 'product_catalogues':
            $relation = $this->handleProductCatalogue($object_id, $id);
            break;
      }

      return $relation;

   }

   private function handleProduct(array $object_id, int $id): array{
      $data = [];
      if(isset($object_id) && is_array($object_id) && count($object_id)){
         foreach($object_id as $key => $val){
            $data[] = [
               'promotion_id' => $id,
               'product_id' => $val
            ];
         }
      }
      return $data;
   }

   private function handleProductCatalogue(array $object_id, int $id){
      $data = [];
      $temp = [];
      $catalogue = $this->productCatalogueRepository->findByIdArray($object_id);
      foreach($catalogue as $key => $val){
         $extraQuery = 'tb3.product_catalogue_id IN (SELECT id FROM product_catalogues WHERE lft >= '.$val['lft'].' AND rgt <= '.$val['rgt'].')';
         $product = $this->productRepository->findProductByCatalogueId($extraQuery);
         if(isset($product) && is_array($product) && count($product)){
            foreach($product as $product){
               $temp[] = $product;
            }
         }

      }
      if(isset($temp) && is_array($temp) && count($temp)){
         foreach($temp as $key => $val){
            $data[] = [
               'promotion_id' => $id,
               'product_id' => $val
            ];
         }
      }

      return $data;
   }


   private function condition(){
      $condition = [];
      if($this->request->getGet('publish')){
         $condition['tb1.publish'] = $this->request->getGet('publish');
      }
      $condition['tb1.deleted_at'] = 0;

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
                  $search = '(tb1.'.$val.' LIKE \'%'.$keyword.'%\')';
               }else{
                  $search = $search.' OR '.'(tb1.'.$val.' LIKE \'%'.$keyword.'%\')';
               }

            }
         }
      }
      return $search;
   }

}
