<?php
namespace App\Libraries;

class Cartbie{

   protected $productRepository;
   protected $voucherRepository;

	public function __construct(){
      $this->productRepository = service('ProductRepository', 'products');
      $this->voucherRepository = service('VoucherRepository', 'vouchers');
   }

   public function formatCart($cart){
      $productId = [];
      $newCart = $cart->contents();
      $productId = array_column($newCart, 'product_id');
      $voucherApplyed = $this->voucherApplyed();
      if(isset($voucherApplyed) && is_array($voucherApplyed) && count($voucherApplyed)){
         $productApplyVoucher = $this->voucherRepository->findProductByVoucher($voucherApplyed['voucherCode'], $productId);
         $productVoucherID = array_column($productApplyVoucher, 'product_id');
      }
      $product = $this->productRepository->findProductByIdArray($productId);
      if(isset($newCart) && is_array($newCart) && count($newCart)){
         foreach($newCart as $key => $val){
            $option = json_decode($val['option'], TRUE);
            if(isset($product) && is_array($product) && count($product)){
               foreach($product as $keyProduct => $valProduct){
                  if($val['product_id'] == $valProduct['id']){
                     $newCart[$key]['detail'] = $valProduct;
                  }
               }
            }
            if(isset($productVoucherID) && is_array($productVoucherID) && count($productVoucherID)){
               foreach($productVoucherID as $keyVoucher => $valVoucher){
                  if($val['product_id'] == $valVoucher){
                     $option['voucher'] = $voucherApplyed;
                     $newCart[$key]['option'] = json_encode($option);
                  }
               }
            }
         }
      }
      return [
         'newCart' => $newCart,
         'oldCart' => $cart,
      ];
   }

   public function findVoucherCart($cart){
      $productId = [];
      if(is_array($cart['newCart']) && count($cart['newCart'])){
         foreach($cart['newCart'] as $key => $val){
            $productId[] = $val['product_id'];
         }
      }
      $voucher = $this->voucherRepository->findAllVoucherCart($productId);
      return $voucher;
   }

   public function voucherApplyed(){
      $voucher = (isset($_COOKIE['voucher'])) ? json_decode($_COOKIE['voucher'], TRUE) : '';
      return $voucher;
   }



}
