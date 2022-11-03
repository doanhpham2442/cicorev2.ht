<?php
namespace App\Controllers\Ajax;
use App\Controllers\FrontendController;

class Search extends FrontendController{


	public function __construct(){
		$this->cart = \Config\Services::cart();
      $this->productRepository = service('ProductRepository', 'products');
      $this->promotionRepository = service('PromotionRepository', 'promotions');
      $this->voucherRepository = service('VoucherRepository', 'vouchers');
      $this->cartBie = service('cartBie');
      $this->cartTotal = $this->cart->total();
      $this->cartTotalItem = $this->cart->totalItems();
	}

   public function index(){
      $keyword = $this->request->getPost('keyword');
      $object = $this->productRepository->search($keyword, 0);


      $html = '';
      if(isset($object) && is_array($object) && count($object)){
         $html = $html.'<ul class="uk-list uk-clearfix">';
         $html = $html.'<li>';
         foreach($object as $key => $val){
            $html = $html.'<div class="search-item uk-clearfix mb15">';
               $html = $html.'<a href="'.write_url($val['canonical']).'" class="image img-cover"><img src="'.getthumb($val['image']).'" alt=""></a>';
               $html = $html.'<div class="info">';
                  $html = $html.'<div class="title"><a href="'.write_url($val['canonical']).'">'.$val['title'].'</a></div>';
               $html = $html.'</div>';
            $html = $html.'</div>';
         }
         $html = $html.'</li>';
         $html = $html.'</ul>';

         echo json_encode($html);die();
      }






   }


}
