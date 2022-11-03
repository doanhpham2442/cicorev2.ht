<?php
namespace App\Libraries;

class Widget{

   protected $productRepository;
   protected $productCatalogueRepository;
   protected $articleCatalogueRepository;
   protected $articleRepository;
   protected $widgetRepository;
   protected $widget;
   protected $productService;
   protected $reviewService;
   protected $language;


	public function __construct($param = []){
      $this->language = $param['language'];
      $this->productRepository = service('productRepository', 'products');
      $this->articleRepository = service('articleRepository', 'articles');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', 'article_catalogues');
      $this->widgetRepository = service('widgetRepository', 'widgets');
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => 'products']
      );
      $this->reviewService = service('ReviewService',
         ['language' => $this->language, 'module' => 'product_reviews']
      );
      $this->widget = [];
	}

   public function findObjectByModule($id = [], $module = '', $language = 0){
      $object = [];
      switch ($module) {
         case 'products':
            $object = $this->productRepository->findProductByIdArray($id, $language);
            break;
         case 'product_catalogues':
            $object = $this->productCatalogueRepository->findByIdArray($id, $language);
            break;
         case 'article_catalogues':
            $object = $this->articleCatalogueRepository->findByIdArray($id, $language);
            break;
         case 'articles':
            $object = $this->articleRepository->findProductByIdArray($id, $language);
            break;
      }
      return $object;
   }

   public function findWidgetByKeyword($keyword = '', $language = 2){
      $this->widget = $this->widgetRepository->findByField($keyword, 'keyword');
      $id = json_decode($this->widget['object_id'], TRUE);
      $this->widget['object'] = $this->findObjectByModule($id, $this->widget['module'], $language);
      return $this->widget;
   }

   public function getWidgetKeyword($keyword = '', $language = 2){
      $this->findWidgetByKeyword($keyword, $language);
      if($this->widget['module'] == 'products'){
         $this->widget = $this->productService->remakeProductByWidgetInformation($this->widget);
         $this->widget = $this->reviewService->remakeProductByReviewInformation($this->widget);
      }
      return $this->widget;
   }

}
