<?php
namespace App\Controllers\Ajax;
use App\Controllers\FrontendController;

class Cart extends FrontendController{

	public $cart;
   public $option;
   protected $productRepository;
   protected $promotionRepository;
   protected $voucherRepository;
   protected $cartBie;
   protected $cartTotalItem;
   protected $cartTotal;
	public function __construct(){
		$this->cart = \Config\Services::cart();
      $this->productRepository = service('ProductRepository', 'products');
      $this->promotionRepository = service('PromotionRepository', 'promotions');
      $this->voucherRepository = service('VoucherRepository', 'vouchers');
      $this->cartBie = service('cartBie');
      $this->cartTotal = $this->cart->total();
      $this->cartTotalItem = $this->cart->totalItems();
	}

	public function addCart(){
      try {
         $productId = $this->request->getPost('productId');
         $quantity = $this->request->getPost('quantity');
         $sku = 'SKU_'.$productId;

         $product = $this->productRepository->findByField($productId, 'tb1.id');
         if(isset($product) && is_array($product) && count($product)){
            $product['promotion'] = $this->promotionRepository->findPromotionByProductId($product['id']);
         }

         $price = getPrice($product, $product['promotion']);
         $cartOption = $this->cartOption($product);
         $data = [
            'id'      => $sku,
            'product_id' => $product['id'],
            'qty'     => (int)$quantity,
            'price'   => $price['priceSale'],
            'name'    => $product['title'],
            'option' => json_encode($cartOption)
         ];
         $flag = $this->cart->insert($data);

         $response = [
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'code' => 200,
            'totalItems' => $this->cart->totalItems(),
            'total' => commas($this->cart->total()),
            'html' => $this->renderMiniCart(),
         ];
		}catch(Exception $e) {
			$response = [
            'message' => $e->getMessage(),
   			'code' => 500,
         ];
		}

      echo json_encode($response); die();

	}

   public function updateCart(){
      try {
         $quantity = $this->request->getPost('quantity');
         $rowid = $this->request->getPost('rowid');

         $cartUpdate = array(
            'rowid'   => $rowid,
            'qty'     => $quantity,
         );
         $this->cart->update($cartUpdate);

         $response = [
            'message' => 'Cập nhật số lượng thành công',
            'code' => 200,
            'totalItems' => $this->cart->totalItems(),
            'total' => commas($this->cart->total()),
            'html' => $this->renderMiniCart(),
         ];
		}catch(Exception $e) {
			$response = [
            'message' => $e->getMessage(),
   			'code' => 500,
         ];
		}


      echo json_encode($response); die();

   }

   public function removeCartItem(){

      try {
         $rowid = $this->request->getPost('rowid');
         $this->cart->remove($rowid);

         echo json_encode([
            'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
            'code' => 200,
   			'totalItems' => $this->cart->totalItems(),
   			'total' =>  commas($this->cart->total()),
            'html' => $this->renderMiniCart(),
   		]);
		}catch(Exception $e) {
			$response = [
            'message' => $e->getMessage(),
   			'code' => 500,
         ];
		}

   }

   public function applyVoucher(){
      $voucherCode = $this->request->getPost('voucher');
      $voucher = $this->voucherRepository->findByField($voucherCode, 'title');
      $response = $this->checkVoucherCondition($voucher);
      $voucherCookie = [];
      if($response['code'] == 200){
         $voucherCookie = [
            'voucherCode' => $voucher['title'],
            'voucherType' => $voucher['type'],
            'voucherDiscountValue' => $voucher['discount_value'],
            'voucherDiscountType' => $voucher['discount_type'],
            'allowCoupon' => $voucher['allowCoupon'],
         ];
      }
      if(isset($voucherCookie) && is_array($voucherCookie) && count($voucherCookie)){
      	setcookie('voucher', json_encode($voucherCookie), time() + 1*24*3600, "/");
      }
      $response['totalItems'] = $this->cartTotalItem;
      $response['total'] =  commas($this->cartTotal);
      echo json_encode($response);

   }

   private function checkVoucherCondition($voucher){
      $response = [];
      switch ($voucher['billCondition']) {
         case 'Số lượng sản phẩm tối thiểu':
            $response = $this->checkVoucherMinItemCondition($voucher);
            break;
         case 'Giá trị mua tối thiểu':
            $response = $this->checkVoucherMinCartTotalCondition($voucher);
            break;
         default:
            $response = $this->checkVoucherConditionDefault($voucher);
            break;
      }
      return $response;

   }

   private function checkVoucherConditionDefault(){
      if($voucher['billCondition'] == 'Không yêu cầu'){
         if($cartTotalItem < $voucher['billCondition']){
            $response = [
               'message' => 'Áp dụng mã giảm giá thành công',
               'code' => 200,
            ];
         }
      }
      return $response;
   }

   private function checkVoucherMinItemCondition($voucher){
      $response = [];
      if($this->cartTotalItem < $voucher['billConditionValue']){
         $response = [
            'message' => 'Bạn phải mua ít nhất '.$voucher['billConditionValue']. ' sản phẩm để có thể áp dụng mã giảm giá này',
            'code' => 500,
         ];
      }
      else{
         $response = [
            'message' => 'Áp dụng mã giảm giá thành công',
            'code' => 200,
         ];
      }
      return $response;
   }

   private function checkVoucherMinCartTotalCondition($voucher){
      $response = [];
      if($this->cartTotal < $voucher['billConditionValue']){
         $response = [
            'message' => 'Giá trị đơn hàng ít nhất '.commas($voucher['billConditionValue']). ' để có thể áp dụng mã giảm giá này',
            'code' => 500,
         ];
      }
      else{
         $response = [
            'message' => 'Áp dụng mã giảm giá thành công',
            'code' => 200,
         ];
      }
      return $response;
   }

   private function renderMiniCart(){
      $cart = $this->cartBie->formatCart($this->cart);
      $html = '';

      $html = $html.'<div class="fl-mini-cart-content" style="opacity: 1;">';
         $html = $html.' <div class="products woocommerce-mini-cart cart_list product_list_widget">';
            $html = $html.'<div class="product woocommerce-mini-cart-item mini_cart_item">';

      if(isset($cart['newCart']) && is_array($cart['newCart']) && count($cart['newCart'])){
         foreach ($cart['newCart'] as $key => $val) {
            $title = $val['detail']['title'];
            $canonical = write_url($val['detail']['canonical']);
            $quantity = $val['qty'];
            $price = commas($val['price']);
            $image = getthumb($val['detail']['image']);
                     $html = $html.'<div class="product-wrapper '.$key.'">';
                       $html = $html.'<div class="thumbnail-wrapper">';
                           $html = $html.'<a href="'.$canonical.'">';
                               $html = $html.'<img width="90" height="90" src="'.$image.'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="'.$title.'">';
                           $html = $html.'</a>';
                       $html = $html.'</div>';
                      $html = $html.' <div class="content-wrapper">';
                           $html = $html.'<h3 class="product-title"><a href="'.$canonical.'">'.$title.'</a></h3>';
                           $html = $html.'<div class="entry-price">';
                               $html = $html.'<span class="quantity">'.$quantity.' ×';
                                   $html = $html.'<span class="woocommerce-Price-amount amount">';
                                       $html = $html.'<bdi><span class="woocommerce-Price-currencySymbol"></span>'.$price.' đ</bdi>';
                                   $html = $html.'</span>';
                               $html = $html.'</span>';
                           $html = $html.'</div>';
                           $html = $html.'<a href="" class="remove remove_from_cart_button removeCartItem" data-rowid="'.$key.'">';
                               $html = $html.'<i class="klbth-icon-cancel"></i>';
                           $html = $html.'</a>';
                       $html = $html.'</div>';
                   $html = $html.'</div>';
               }

               $html = $html.'<p class="woocommerce-mini-cart__total total">';
                   $html = $html.'<strong>Tổng Tiền:</strong>';
                  $html = $html.' <span class="woocommerce-Price-amount amount">';
                       $html = $html.'<bdi><span class="woocommerce-Price-currencySymbol"></span>'.commas($cart['oldCart']->total()).'đ</bdi>';
                   $html = $html.'</span>';
               $html = $html.'</p>';
               $html = $html.'<p class="woocommerce-mini-cart__buttons buttons">';
                 $html = $html.'<a href="'.write_url('gio-hang').'" class="button wc-forward">Xem giỏ hàng</a>';
                 $html = $html.'<a href="'.write_url('thanh-toan').'" class="button checkout wc-forward">Thanh toán</a>';
              $html = $html.'</p>';

               $html = $html.'</div>';
            $html = $html.' </div>';
         $html = $html.'<div>';

         return $html;

      }

   }

   private function cartOption($product){
      $option = [];
      if(isset($product['promotion']) && is_array($product['promotion']) && count($product['promotion'])){
         foreach($product['promotion'] as $key => $val){
            $option['promotion'][] = $val;
         }
      }


      return $option;
   }


}
