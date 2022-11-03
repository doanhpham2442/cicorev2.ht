<?php
namespace App\Controllers\Frontend\Article;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{
   protected $articleService;
   protected $language;
   protected $systemRepository;
   protected $articleRepository;
   protected $productRepository;
   protected $productCatalogueRepository;
   protected $cartBie;
   protected $widget;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'article_catalogues';
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', $this->module);
      $this->articleService = service('ArticleService',
         ['language' => $this->language, 'module' => 'articles']
      );
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->articleRepository = service('ArticleRepository', 'articles');
      $this->productRepository = service('ProductRepository', 'products');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->cartBie = service('cartbie');
      $this->widget = service('widget', ['language' => $this->language]);

	}

	public function index($id = 0, $page = 1){
	   $articleCatalogue = $this->articleCatalogueRepository->findByField($id, 'tb1.id');
      $module = $this->module;
      $article = $this->articleService->index($articleCatalogue, $page);
      $canonical = $article['canonical'];
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);


      $widget = [
         'post' =>  $this->widget->getWidgetKeyword('post-highlight', $this->language),
      ];
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      $cart = $this->cartBie->formatCart($this->cart);
      $js = ['cart','core'];
      $seo = seo($articleCatalogue, $canonical, 'page');
      $template = route('frontend.article.catalogue.index');
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList','canonical', 'article', 'general','articleCatalogue','cart', 'seo', 'product', 'widget'
         )
      );
	}


}
