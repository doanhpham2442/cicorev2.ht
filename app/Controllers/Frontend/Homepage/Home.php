<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;

class Home extends FrontendController{

	public $data = [];
   protected $language;
   protected $systemRepository;
   protected $widgetRepository;
   protected $widget;
   protected $cartBie;
   protected $provinceRepository;

	public function __construct(){
	   $this->language = $this->currentLanguage();
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->slideRepository = service('slideRepository', 'slides');
      $this->productRepository = service('ProductRepository', 'products');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->widgetRepository = service('WidgetRepository', 'widgets');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->widget = service('widget', ['language' => $this->language]);
      $this->cartBie = service('cartbie');
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => 'products']
      );
	}



	public function index(){

      $province = converProvinceArray($this->provinceRepository->allProvince());
      $slide = $this->slideRepository->findByField('main-slide', 'keyword', $this->language);
      $asideBanner = $this->slideRepository->findByField('aside', 'keyword', $this->language);
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $widget = [
         'bestSeller' =>  $this->widget->getWidgetKeyword('best-seller', $this->language),
         'trending' =>  $this->widget->getWidgetKeyword('trending', $this->language),
         'newProduct' =>  $this->widget->getWidgetKeyword('new-product', $this->language),
         'feedback' =>  $this->widget->getWidgetKeyword('feedback', $this->language),
         'categories' =>  $this->widget->getWidgetKeyword('categories', $this->language),
      ];


      $general = convertGeneral($this->systemRepository->all('keyword, content'));

      $cart = $this->cartBie->formatCart($this->cart);
      $seo = [
         'meta_title' => (isset($general['seo_meta_title']) ? $general['seo_meta_title'] : ''),
         'meta_description' => (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : ''),
         'meta_image' => $general['homepage_logo'],
         'oh_type' => 'website',
         'canonical' => BASE_URL,
         'module' => 'homepage'
      ];
      $js = ['cart','core'];
		$template = route('frontend.homepage.home.index');
      return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'general', 'seo', 'product', 'productCatalogueList', 'slide', 'asideBanner','widget','cart','js', 'province'
         )
      );

	}



}
