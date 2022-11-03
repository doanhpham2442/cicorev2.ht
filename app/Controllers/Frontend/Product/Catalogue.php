<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{
   protected $productService;
   protected $language;
   protected $systemRepository;
   protected $productRepository;
   protected $cartBie;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'product_catalogues';
      $this->productCatalogueRepository = service('ProductCatalogueRepository', $this->module);
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => 'products']
      );
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->productRepository = service('ProductRepository', 'products');
      $this->cartBie = service('cartbie');

	}

	public function index($id = 0, $page = 1){
	   $productCatalogue = $this->productCatalogueRepository->findByField($id, 'tb1.id');
      $module = $this->module;
      $product = $this->productService->index($productCatalogue, $page);
      // dd($product);

      $canonical = $product['canonical'];
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      $seo = seo($productCatalogue, $canonical, 'page');
      $template = route('frontend.product.catalogue.index');
      $cart = $this->cartBie->formatCart($this->cart);
      $js = ['cart','core'];

		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList','canonical', 'product', 'general','productCatalogue','cart', 'seo', 'js'
         )
      );
	}


}
