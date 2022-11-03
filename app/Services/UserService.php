<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class UserService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $pagination;
   protected $userRepository;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->userRepository = service('UserRepository', $this->module);
   }


   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();


      $config['total_rows'] = $this->userRepository->count($condition, $keyword);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.user.user.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$user = $this->userRepository->paginate($condition, $keyword, $config, $page);
		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($user) ?? [],
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = requestAccept(['email', 'fullname', 'user_catalogue_id', 'gender', 'image', 'birthday', 'address', 'phone', 'cityid', 'districtid', 'wardid'], Auth::id());
         $payload['publish'] = 1;
         $password = $this->renderPassword();
         $payload['salt'] = $password['salt'];
         $payload['password'] = $password['password'];
         $id = $this->userRepository->create($payload);
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
         $payload = requestAccept(['email', 'fullname', 'user_catalogue_id', 'gender', 'image', 'birthday', 'address', 'phone', 'cityid', 'districtid', 'wardid'], Auth::id());
         $flag = $this->userRepository->update($payload, $id);
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
         $this->userRepository->softDelete($id);
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

   private function renderPassword(){
      helper('text');
      $salt = random_string('alnum', 168);
   	$password = password_encode($this->request->getPost('password'), $salt);
      return [
         'salt' => $salt,
         'password' => $password,
      ];
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
