<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Promotion extends BaseController{
   protected $promotionService;
   protected $authentication;
   protected $language;
   protected $promotionRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'promotions';
      $this->promotionService = service('PromotionService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->promotionRepository = service('promotionRepository', $this->module);
      $this->productRepository = service('productRepository', 'products');
      $this->productCatalogueRepository = service('productCatalogueRepository', 'products_catalogues');

	}

	public function search(){

      $post = $this->request->getPost();
      $object = [];

      $keyword = trim($post['keyword']);

      // pre($post);

      switch ($post['module']) {
         case 'products':
            $object = $this->productRepository->search($keyword, $post['start']);
            break;
         case 'product_catalogues':
            $object = $this->productCatalogueRepository->search($keyword, $post['start']);
            break;
      }


      echo json_encode($object);die();

	}



}
