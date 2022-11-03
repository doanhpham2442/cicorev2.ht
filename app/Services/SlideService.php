<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class SlideService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $pagination;
   protected $slideRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->slideRepository = service('SlideRepository', $this->module);
   }


   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();


      $config['total_rows'] = $this->slideRepository->count($condition, $keyword);

		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.slide.slide.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$slide = $this->slideRepository->paginate($condition, $keyword, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($slide) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = requestAccept(['title', 'keyword', 'description'], Auth::id());
         $id = $this->slideRepository->create($payload);
         if($id > 0){
            $payloadTranslate = $this->execute($id, $this->request->getPost('slide'));
            $this->slideRepository->createBatch($payloadTranslate, 'slide_translate');
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
         $payload = requestAccept(['title', 'keyword', 'description'], Auth::id());
         $flag = $this->slideRepository->update($payload, $id);
         if($flag > 0){
            $payloadTranslate = $this->execute($id, $this->request->getPost('slide'));
            $this->slideRepository->deleteSlide($id, 'slide_translate', $this->language);
            $this->slideRepository->createBatch($payloadTranslate, 'slide_translate');
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
         /* Xóa bản ghi - xóa user */
         $this->slideRepository->deleteSlide($id, 'slide_translate', $this->language);
         $this->slideRepository->softDelete($id);

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

   public function execute($id, $slide){
      $data = [];
      if(isset($slide['image']) && is_array($slide['image']) && count($slide['image'])){
         foreach($slide['image'] as $key => $val){
            $data[] = [
               'slide_id' => $id,
               'language_id' => $this->language,
               'title' => $slide['title'][$key],
               'image' => $val,
               'canonical' => $slide['canonical'][$key],
               'description' => $slide['description'][$key]
            ];
         }
      }
      return $data;
   }


   private function condition(){
      $condition = [];
      if($this->request->getGet('publish')){
         $condition['publish'] = $this->request->getGet('publish');
      }
      $condition['deleted_at'] = 0;

      return $condition;
   }

   private function keyword(): string{
      $search = '';
      if(!empty($this->request->getGet('keyword'))){
         $fieldSearch = ['fullname', 'email', 'address'];

         $keyword = $this->request->getGet('keyword');
         if(isset($fieldSearch) && is_array($fieldSearch) && count($fieldSearch)){
            foreach($fieldSearch as $key => $val){
               if(empty($search)){
                  $search = '('.$val.' LIKE \'%'.$keyword.'%\')';
               }else{
                  $search = $search.' OR '.'('.$val.' LIKE \'%'.$keyword.'%\')';
               }

            }
         }
      }
      return $search;
   }

}
