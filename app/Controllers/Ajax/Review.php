<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Review extends BaseController{
   protected $authentication;
   protected $language;
   protected $reviewRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'reviews';
      $this->reviewRepository = service('reviewRepository', 'product_reviews');

	}

	public function send(){
      $post = $this->request->getPost('post');
      $payload = [];
      if(isset($post) && is_array($post) && count($post)){
         foreach($post as $key => $val){
            $payload[$val['name']] = $val['value'];
         }
      }
      $payload['created_at'] = currentTime();
      $payload['publish'] = 0;
      unset($payload['reset']);
      $id = $this->reviewRepository->create($payload);
      if($id > 0){
         echo 200;die();
      }
      echo 505;die();
	}



}
