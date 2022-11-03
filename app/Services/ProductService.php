<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class ProductService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $model;
	protected $nestedsetbie;
   protected $pagination;
   protected $productRepository;
   protected $productCatalogueRepository;
   protected $promotionRepository;
   protected $reviewRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'product_catalogues', 'language' => $this->language, 'foreignkey' => 'product_catalogue_id']
      );
      $this->productRepository = service('ProductRepository', $this->module);
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->routerRepository = service('routerRepository', 'routers');
      $this->promotionRepository = service('promotionRepository', 'promotions');
      $this->reviewRepository = service('reviewRepository', 'product_reviews');
   }


   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();

      $catalogue = [];
      $query = '';
      if($this->request->getGet('product_catalogue_id')){
         $productCatalogueID = $this->request->getGet('product_catalogue_id');
         $catalogue = $this->productCatalogueRepository->findByField($productCatalogueID, 'tb1.id');
         $catalogue = ($catalogue) ?? [];
         $query = $this->query($catalogue);
      }
      $config['total_rows'] = $this->productRepository->count($condition, $keyword, $query);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.product.product.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$productCatalogue = $this->productRepository->paginate($condition, $keyword, $query, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($productCatalogue) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = $this->request();
         $id = $this->productRepository->create($payload);
         if($id > 0){
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['product_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);
            $translateID = $this->productRepository->createTranslate($payloadTranslate, 'product_translate');
            $payloadRouters = router('Product','Product', $id, $this->module, $this->language, $payloadTranslate['canonical']);

            $routerID = $this->routerRepository->create($payloadRouters);
            //Insert Relationship
            $relation = $this->relation($id);
            $this->productRepository->createRelation($relation, 'product_catalogue_product');
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
         $payload = requestAccept(['product_catalogue_id', 'catalogue','image', 'price', 'price_sale', 'code', 'made_in','album','publish'], Auth::id());
         $payload['price'] = str_replace('.','', $payload['price']);
         $payload['price_sale'] = str_replace('.','', $payload['price_sale']);
         $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;
         $flag = $this->productRepository->update($payload, $id);
         if($flag > 0){
            //Translate
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['product_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);

            $flagTranslate = $this->productRepository->updateTranslate($payloadTranslate, 'product_translate', ['product_id' => $id, 'language_id' => $this->language]);
            $this->routerRepository->deleteRouter($id, $this->module);
            $payloadRouters = router('Product','Product', $id, $this->module, $this->language, $payloadTranslate['canonical']);
            $routerID = $this->routerRepository->create($payloadRouters);

            //Relation
            $relation = $this->relation($id);
            $this->productRepository->deleteRelation($id, 'product_catalogue_product', 'product_id');
            $this->productRepository->createRelation($relation, 'product_catalogue_product');


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
         $this->productRepository->softDelete($id);
         $this->routerRepository->deleteRouter($id, $this->module);
         $this->productRepository->deleteRelation($id, 'product_catalogue_product', 'product_id');

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
      $payload = requestAccept(['product_catalogue_id', 'catalogue','image', 'price', 'price_sale', 'code', 'made_in','album','publish'], Auth::id());
      $payload['price'] = str_replace('.','', $payload['price']);
      $payload['price_sale'] = str_replace('.','', $payload['price_sale']);
      $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;

      return $payload;
   }


   private function query(array $catalogue): string{
      $extraQuery = '';
      if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
         $extraQuery = 'tb3.product_catalogue_id IN (SELECT id FROM product_catalogues WHERE lft >= '.$catalogue['lft'].' AND rgt <= '.$catalogue['rgt'].')';
      }
      return $extraQuery;
   }

   private function relation($id){
      $catalogue = ($this->request->getPost('catalogue')) ?? [];
      $catalogueid = $this->request->getPost('product_catalogue_id');
      array_push($catalogue, $catalogueid);
      $newCatalogue = array_unique($catalogue);
      $relation = [];
      foreach($newCatalogue as $key => $val){
         $relation[] = [
            'product_id' => $id,
            'product_catalogue_id' => $val,
         ];
      }
      return $relation;
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

   public function remakeProductByWidgetInformation(array $widget = []){
      if(isset($widget['object']) && is_array($widget['object']) && count($widget['object'])){
         foreach($widget['object'] as $key => $val){
            $promotion = $this->promotionRepository->findPromotionByProductId($val['id']);
            $widget['object'][$key]['promotion'] = $promotion;

         }
      }
      return $widget;
   }

   public function index($productCatalogue, $page){
      helper(['mypagination']);
		$page = (int)$page;
      $perpage = 12;
      $config['total_rows'] = $this->productRepository->countIndex($productCatalogue);
      $config['base_url'] = write_url($productCatalogue['canonical'], FALSE, TRUE);
		if($config['total_rows'] > 0){
			$config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
         if($page >= 2){
             $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
         }
			$page = $page - 1;
			$product = $this->productRepository->paginateIndex($productCatalogue, $config, $page);
         if(isset($product) && is_array($product) && count($product)){
            foreach($product as $key => $val){
               $product[$key]['promotion'] = $this->promotionRepository->findPromotionByProductId($val['id']);
               $product[$key]['review'] = $this->reviewRepository->averateReviewByProductId($val['id']);
            }
         }
		}
      if(!isset($canonical) || empty($canonical)){
          $canonical = $config['base_url'].HTSUFFIX;
      }
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($product) ?? [],
         'canonical' => $canonical,
      ];
   }

}
