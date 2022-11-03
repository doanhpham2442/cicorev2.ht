<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class SystemService
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
      $this->systemRepository = service('SystemRepository', $this->module);
   }


   public function execute(){
      $this->db->transBegin();
      try{
         $payload = requestAccept(['config']);
         $this->systemRepository->deleteConfig($this->language);
         $config = $this->handleConfig($payload);
         $flag =	$this->systemRepository->createBatch($config, $this->module);

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

   public function handleConfig($payload){
      $data = [];
      foreach($payload['config'] as $key => $val){
         $data[] = [
            'language_id' => $this->language,
            'keyword' => $key,
            'content' => $val,
            'userid_updated' => Auth::id(),
            'updated_at' => currentTime()
         ];

      }
      return $data;
   }
}
