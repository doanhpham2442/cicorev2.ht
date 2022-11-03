<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class ReviewService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $pagination;
   protected $reviewRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->reviewRepository = service('ReviewRepository', $this->module);
   }


   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();


      $config['total_rows'] = $this->reviewRepository->count($condition, $keyword);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.review.review.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$review = $this->reviewRepository->paginate($condition, $keyword, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($review) ?? [],
      ];
   }


   public function delete($id){
      $id = (int)$id;
      try{
         /* Xóa bản ghi - xóa review */
         $this->reviewRepository->softDelete($id);
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
         $fieldSearch = ['fullname', 'email', 'description'];

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

   public function remakeProductByReviewInformation(array $widget = []){
      if(isset($widget['object']) && is_array($widget['object']) && count($widget['object'])){
         foreach($widget['object'] as $key => $val){
            $review = $this->reviewRepository->averateReviewByProductId($val['id']);
            $widget['object'][$key]['review'] = $review;

         }
      }
      return $widget;
   }

}
