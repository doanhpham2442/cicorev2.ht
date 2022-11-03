<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class AttributeService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $model;
	protected $nestedsetbie;
   protected $pagination;
   protected $attributeRepository;
   protected $attributeCatalogueRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'attribute_catalogues', 'language' => $this->language, 'foreignkey' => 'attribute_catalogue_id']
      );
      $this->attributeRepository = service('AttributeRepository', $this->module);
      $this->attributeCatalogueRepository = service('AttributeCatalogueRepository', 'attribute_catalogues');
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
      if($this->request->getGet('attribute_catalogue_id')){
         $attributeCatalogueID = $this->request->getGet('attribute_catalogue_id');
         $catalogue = $this->attributeCatalogueRepository->findByField($attributeCatalogueID, 'tb1.id');
         $catalogue = ($catalogue) ?? [];
         $query = $this->query($catalogue);
      }
      $config['total_rows'] = $this->attributeRepository->count($condition, $keyword, $query);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.attribute.attribute.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$attributeCatalogue = $this->attributeRepository->paginate($condition, $keyword, $query, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($attributeCatalogue) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = requestAccept(['attribute_catalogue_id', 'catalogue','publish'], Auth::id());
         $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;
         $id = $this->attributeRepository->create($payload);
         if($id > 0){
            $payloadTranslate = requestAccept(
               ['title']
            );
            $payloadTranslate['attribute_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $translateID = $this->attributeRepository->createTranslate($payloadTranslate, 'attribute_translate');
            $relation = $this->relation($id);
            $this->attributeRepository->createRelation($relation, 'attribute_catalogue_attribute');
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
         $payload = requestAccept(['attribute_catalogue_id', 'catalogue','publish'], Auth::id());
         $payload['catalogue'] = (isset($payload['catalogue'])) ? json_encode($payload['catalogue']) : null;
         $flag = $this->attributeRepository->update($payload, $id);
         if($flag > 0){
            //Translate
            $payloadTranslate = requestAccept(
               ['title']
            );
            $payloadTranslate['attribute_id'] = $id;
            $payloadTranslate['language_id'] = $this->language;
            $flagTranslate = $this->attributeRepository->updateTranslate($payloadTranslate, 'attribute_translate', ['attribute_id' => $id, 'language_id' => $this->language]);
            //Relation
            $relation = $this->relation($id);
            $this->attributeRepository->deleteRelation($id, 'attribute_catalogue_attribute', 'attribute_id');
            $this->attributeRepository->createRelation($relation, 'attribute_catalogue_attribute');


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
         $this->attributeRepository->softDelete($id);
         $this->routerRepository->deleteRouter($id, $this->module);
         $this->attributeRepository->deleteRelation($id, 'attribute_catalogue_attribute', 'attribute_id');

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
         $extraQuery = 'tb3.attribute_catalogue_id IN (SELECT id FROM attribute_catalogues WHERE lft >= '.$catalogue['lft'].' AND rgt <= '.$catalogue['rgt'].')';
      }
      return $extraQuery;
   }

   private function relation($id){
      $catalogue = ($this->request->getPost('catalogue')) ?? [];
      $catalogueid = $this->request->getPost('attribute_catalogue_id');
      array_push($catalogue, $catalogueid);
      $newCatalogue = array_unique($catalogue);
      $relation = [];
      foreach($newCatalogue as $key => $val){
         $relation[] = [
            'attribute_id' => $id,
            'attribute_catalogue_id' => $val,
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
         $fieldSearch = ['title'];

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




}
