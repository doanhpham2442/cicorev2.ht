<?php
namespace App\Controllers\Frontend\Contact;
use App\Controllers\FrontendController;

class Contact extends FrontendController{
   protected $language;
   protected $systemRepository;
   protected $productRepository;
   protected $productCatalogueRepository;
   protected $cartBie;
   protected $widget;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'contacts';

      $this->systemRepository = service('SystemRepository', 'systems');
      $this->productRepository = service('ProductRepository', 'products');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->cartBie = service('cartbie');
      $this->widget = service('widget', ['language' => $this->language]);

	}

	public function index($id = 0, $page = 1){
      $module = $this->module;
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      $cart = $this->cartBie->formatCart($this->cart);
      $seo = [
         'meta_title' => 'Liên hệ',
         'meta_description' => 'Trang thanh toán',
         'canonical' => write_url('gio-hang', TRUE, FALSE)
      ];
      $js = ['cart','core'];
      $template = route('frontend.contact.index');
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList','canonical', 'article', 'general','cart', 'seo', 'product','js'
         )
      );
	}


}
