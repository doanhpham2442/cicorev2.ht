<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Widget extends BaseController{
   protected $promotionService;
   protected $authentication;
   protected $language;
   protected $widgetRepository;
   protected $widget;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'widgets';
      $this->promotionService = service('WidgetService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->widgetRepository = service('widgetRepository', $this->module);
      $this->productRepository = service('productRepository', 'products');
      $this->articleRepository = service('articleRepository', 'articles');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', 'article_catalogues');
      $this->widget = service('widget', ['language' => $this->language]);

	}

	public function search(){
      $post = $this->request->getPost();
      $keyword = trim($post['keyword']);

      $object = [];

      switch ($post['module']) {
         case 'products':
            $object = $this->productRepository->search($keyword, $post['start']);
            break;
            case 'articles':
               $object = $this->articleRepository->search($keyword, $post['start']);
               break;
         case 'product_catalogues':
            $object = $this->productCatalogueRepository->search($keyword, $post['start']);
            break;
         case 'article_catalogues':
            $object = $this->articleCatalogueRepository->search($keyword, $post['start']);
            break;

      }

      echo json_encode($object);die();

	}



}
