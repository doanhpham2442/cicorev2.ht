<?php
namespace App\Controllers\Frontend\Article;
use App\Controllers\FrontendController;

class Article extends FrontendController{
   protected $articleService;
   protected $language;
   protected $systemRepository;
   protected $articleRepository;
   protected $promotionRepository;
   protected $reviewRepository;
   protected $reviewService;
   protected $cartBie;
   protected $widget;
   protected $productCatalogueRepository;
   protected $provinceRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'articles';
         $this->articleRepository = service('ArticleRepository', $this->module);
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', 'article_catalogues');
      $this->articleService = service('ArticleService',
         ['language' => $this->language, 'module' => 'articles']
      );
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->productRepository = service('ProductRepository', 'products');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->cartBie = service('cartbie');
      $this->widget = service('widget', ['language' => $this->language]);

	}

	public function index($id = 0, $page = 1){
      $article = $this->articleRepository->findByField($id, 'tb1.id');
      $articleCatalogue =  $this->articleCatalogueRepository->findByField($article['article_catalogue_id'], 'tb1.id');

      // $canonical = $article['canonical'];
      $canonical = write_url($article['canonical'], TRUE, TRUE);
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);

      /* article relate and promotion  */
      $articleRelate = $this->articleRepository->articleRelate($article['article_catalogue_id'], 5);

      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);

      $widget = [
         'post' =>  $this->widget->getWidgetKeyword('post-highlight', $this->language),
      ];

      $province = converProvinceArray($this->provinceRepository->allProvince());
      $seo = seo($article, $canonical, 'article');
      $cart = $this->cartBie->formatCart($this->cart);
      $template = route('frontend.article.article.index');
      $js = ['cart','core'];
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList','canonical', 'article', 'general','articleCatalogue','articleRelate', 'js', 'seo','cart', 'product', 'widget', 'province'
         )
      );
	}




}
