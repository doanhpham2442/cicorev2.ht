<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class ArticleService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $model;
	protected $nestedsetbie;
   protected $pagination;
   protected $articleRepository;
   protected $articleCatalogueRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'article_catalogues', 'language' => $this->language, 'foreignkey' => 'article_catalogue_id']
      );
      $this->articleRepository = service('ArticleRepository', $this->module);
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', 'article_catalogues');
      $this->routerRepository = service('routerRepository', 'routers');
   }




   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();

      $catalogue = [];
      $query = '';
      if($this->request->getGet('article_catalogue_id')){
         $articleCatalogueID = $this->request->getGet('article_catalogue_id');
         $catalogue = $this->articleCatalogueRepository->findByField($articleCatalogueID, 'tb1.id');
         $catalogue = ($catalogue) ?? [];
         $query = $this->query($catalogue);
      }
      $config['total_rows'] = $this->articleRepository->count($condition, $keyword, $query);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.article.article.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$articleCatalogue = $this->articleRepository->paginate($condition, $keyword, $query, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($articleCatalogue) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = requestAccept(['article_catalogue_id', 'catalogue','image','album','publish'], Auth::id());
         $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;
         $id = $this->articleRepository->create($payload);
         if($id > 0){
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['article_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);
            $translateID = $this->articleRepository->createTranslate($payloadTranslate, 'article_translate');
            $payloadRouters = router('Article','Article', $id, $this->module, $this->language, $payloadTranslate['canonical']);

            $routerID = $this->routerRepository->create($payloadRouters);
            //Insert Relationship
            $relation = $this->relation($id);
            $this->articleRepository->createRelation($relation, 'article_catalogue_article');
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
         $payload = requestAccept(['article_catalogue_id', 'catalogue','image','album','publish'], Auth::id());
         $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;
         $flag = $this->articleRepository->update($payload, $id);
         if($flag > 0){
            //Translate
            $payloadTranslate = requestAccept(
               ['title', 'canonical','description','content','meta_title','meta_description','language_id']
            );
            $payloadTranslate['article_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $payloadTranslate['canonical'] = slug($payloadTranslate['canonical']);
            $flagTranslate = $this->articleRepository->updateTranslate($payloadTranslate, 'article_translate', ['article_id' => $id, 'language_id' => $this->language]);

            $this->routerRepository->deleteRouter($id, $this->module);
            $payloadRouters = router('Article','Article', $id, $this->module, $this->language, $payloadTranslate['canonical']);
            $routerID = $this->routerRepository->create($payloadRouters);

            //Relation
            $relation = $this->relation($id);
            $this->articleRepository->deleteRelation($id, 'article_catalogue_article', 'article_id');
            $this->articleRepository->createRelation($relation, 'article_catalogue_article');


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
         $this->articleRepository->softDelete($id);
         $this->routerRepository->deleteRouter($id, $this->module);
         $this->articleRepository->deleteRelation($id, 'article_catalogue_article', 'article_id');

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

   private function query(array $catalogue): string{
      $extraQuery = '';
      if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
         $extraQuery = 'tb3.article_catalogue_id IN (SELECT id FROM article_catalogues WHERE lft >= '.$catalogue['lft'].' AND rgt <= '.$catalogue['rgt'].')';
      }
      return $extraQuery;
   }

   private function relation($id){
      $catalogue = ($this->request->getPost('catalogue')) ?? [];
      $catalogueid = $this->request->getPost('article_catalogue_id');
      array_push($catalogue, $catalogueid);
      $newCatalogue = array_unique($catalogue);
      $relation = [];
      foreach($newCatalogue as $key => $val){
         $relation[] = [
            'article_id' => $id,
            'article_catalogue_id' => $val,
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

   public function index($articleCatalogue, $page){
      helper(['mypagination']);
      $page = (int)$page;
      $perpage = 12;
      $config['total_rows'] = $this->articleRepository->countIndex($articleCatalogue);
      $config['base_url'] = write_url($articleCatalogue['canonical'], FALSE, TRUE);
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
         $product = $this->articleRepository->paginateIndex($articleCatalogue, $config, $page);
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
