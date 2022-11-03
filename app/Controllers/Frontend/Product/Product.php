<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Product extends FrontendController{
   protected $productService;
   protected $language;
   protected $systemRepository;
   protected $productRepository;
   protected $promotionRepository;
   protected $reviewRepository;
   protected $reviewService;
   protected $cartBie;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'product_catalogues';
      $this->productCatalogueRepository = service('ProductCatalogueRepository', $this->module);
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => 'products']
      );
      $this->reviewService = service('ReviewService',
         ['language' => $this->language, 'module' => 'product_reviews']
      );
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->productRepository = service('ProductRepository', 'products');
      $this->promotionRepository = service('PromotionRepository', 'promotions');
      $this->reviewRepository = service('ReviewRepository', 'product_reviews');
      $this->cartBie = service('cartbie');

	}

	public function index($id = 0, $page = 1){
      $product = $this->productRepository->findByField($id, 'tb1.id');
      $productCatalogue =  $this->productCatalogueRepository->findByField($product['product_catalogue_id'], 'tb1.id');
      $product['promotion'] = $this->promotionRepository->findPromotionByProductId($product['id']);


      // $canonical = $product['canonical'];
      $canonical = write_url($product['canonical'], TRUE, TRUE);
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      /* product relate and promotion  */
      $productRelate = $this->productRepository->productRelate($product['product_catalogue_id'], 5);
      if(isset($productRelate) && is_array($productRelate) && count($productRelate)){
         foreach($productRelate as $key => $val){
            $productRelate[$key]['promotion'] = $this->promotionRepository->findPromotionByProductId($val['id']);
            $productRelate[$key]['review'] = $this->reviewRepository->averateReviewByProductId($val['id']);
         }
      }
      $productReview = $this->reviewRepository->findReviewByProductId($product['id']);
      $productReviewStatistic = $this->reviewRepository->averateReviewByProductId($product['id']);

      $seo = seo($product, $canonical, 'product');
      $cart = $this->cartBie->formatCart($this->cart);
      $template = route('frontend.product.product.index');
      $js = ['review','cart','core'];
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList','canonical', 'product', 'general','productCatalogue','productRelate', 'js', 'productReview', 'productReviewStatistic', 'seo','cart'
         )
      );
	}




}
