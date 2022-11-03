<div class="cart-cart">
   <h2 class="heading-2 mb20"><span>Giỏ hàng</span></h2>
   <div class="product-cart">
      <?php
         $totalVoucherDiscount = 0;
         if(isset($cart['newCart']) && is_array($cart['newCart']) && count($cart['newCart'])){
            foreach($cart['newCart'] as $key => $val){
               $title = $val['detail']['title'];
               $canonical = write_url($val['detail']['canonical']);
               $quantity = $val['qty'];
               $price = commas($val['price']);
               $image = getthumb($val['detail']['image']);
               $subTotal = commas($val['price']*$quantity);
               $option = json_decode($val['option'], TRUE);
               $voucherDiscount = (isset($option['voucher']['voucherDiscountValue'])) ? $option['voucher']['voucherDiscountValue']  : 0;
               $totalVoucherDiscount = $totalVoucherDiscount + $voucherDiscount;

      ?>
      <div class="product-block mb20" data-rowid="<?php echo $key; ?>">
           <div class="uk-grid uk-grid-medium">
              <div class="uk-width-small-1-1 uk-width-medium-1-3">
                   <div class="thumb">
                       <a class="image img-cover" href="<?php echo $canonical; ?>" title="<?php echo $title; ?>" class="image"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
                       <div class="number"><?php echo $quantity; ?></div>
                   </div>
              </div>
              <div class="uk-width-small-1-1 uk-width-medium-2-3">
                   <div class="info">
                       <h3 class="title"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
                       <div>
                           <div class="uk-flex uk-flex-middle uk-flex-space-between">
                              <div class="buttons_added">
                                  <input class="minus is-form" type="button" value="-">
                                  <input aria-label="quantity" class="input-qty" max="100" min="0" name="" type="number" value="<?php echo $quantity; ?>" data-rowid="<?php echo $key; ?>" data-price="<?php echo $val['price'] ?>">
                                  <input class="plus is-form" type="button" value="+">
                              </div>
                              <?php if($voucherDiscount > 0){ ?>
                              <?php $finalPrice = ($val['price']*$quantity) - $voucherDiscount; ?>
                              <?php  ?>
                              <div class="price-cart">
                                  <div class="new-pricce"><?php echo commas($finalPrice) ; ?>đ</div>
                                  <div class="old-pricce"><del><?php echo $subTotal; ?>đ</del></div>
                              </div>
                           <?php }else{ ?>
                              <div class="price-cart">
                                  <div class="new-pricce"><?php echo $subTotal; ?>đ</div>
                              </div>
                           <?php } ?>
                           </div>
                       </div>

                       <div class="btn-close removeCartItem" data-rowid="<?php echo $key; ?>"><span>✕</span></div>
                   </div>
              </div>
           </div>
      </div>
   <?php }}else{ echo '<div class="cart-no-item">Chưa có sản phẩm nào trong giỏ hàng</div>'; } ?>
   </div>
   <?php if(isset($voucher) && is_array($voucher) && count($voucher)){ ?>
   <div class="discount-block">
        <div class="coupon-public">
           <div class="coupons">
             <?php foreach($voucher as $key => $val){ ?>
                <?php $activeClass =  (isset($voucherApplyed['voucherCode']) &&  $voucherApplyed['voucherCode'] == $val['title'] ) ? 'active' : ''; ?>
                <div class="coupon voucher-item <?php echo $activeClass; ?>" data-voucher="<?php echo $val['title']; ?>">
                    <div class="coupon-left"></div>
                    <div class="coupon-right">
                       <div class="coupon-title">
                           <?php echo $val['title'] ?>
                           <span class="coupon-count"><i>(Còn <?php echo $val['countLimitValue'] ?>)</i></span>
                       </div>
                       <div class="coupon-description"><?php echo $val['description']; ?></div>
                    </div>
                </div>
               <?php } ?>
           </div>
        </div>
        <div class="discount-box">
           <?php $voucherCode = (isset($voucherApplyed['voucherCode'])) ? $voucherApplyed['voucherCode'] : ''  ?>
           <input type="text" placeholder="Mã giảm giá" name="voucher" value="<?php echo $voucherCode; ?>" />
           <input type="hidden"  name="voucherDiscountValue" value="<?php echo (isset($voucherApplyed['voucherType']) && $voucherApplyed['voucherType'] == 'bill') ? $voucherApplyed['voucherDiscountValue'] : 0; ?>" />
           <input type="hidden"  name="voucherDiscountType" value="<?php echo (isset($voucherApplyed['voucherType']) && $voucherApplyed['voucherType'] == 'bill') ? $voucherApplyed['voucherDiscountType'] : ''; ?>" />
           <a disabled="disabled" class="applyVoucher"  name="applyVoucher">
                Áp dụng
           </a>
        </div>
        <div class="discount-actions">
        </div>
   </div>
   <?php } ?>
   <div class="price-block">
        <div class="price-item uk-flex uk-flex-middle uk-flex-space-between">
           <span class="price-title">Tạm Tính</span>
           <span class="price-number"><?php echo commas($cart['oldCart']->total()) ?>đ</span>
        </div>
        <div class="price-item uk-flex uk-flex-middle uk-flex-space-between">
           <span class="price-title">Giảm giá</span>
           <span class="price-number">
             <?php $discount = (isset($voucherApplyed['voucherDiscountValue']) && $voucherApplyed['voucherType'] == 'bill') ? $voucherApplyed['voucherDiscountValue'] : 0 ?>
             - <?php echo commas($discount + $totalVoucherDiscount); ?> đ
          </span>
        </div>
        <div class="price-item uk-flex uk-flex-middle uk-flex-space-between">
           <span class="price-title">Phí giao hàng</span>
           <span class="price-number"> Miễn phí </span>
        </div>
        <div class="price-sum uk-flex uk-flex-middle uk-flex-space-between">
           <span class="price-title">Tổng</span>
           <div class="price-number">
             <?php $totalDiscount = $discount + $totalVoucherDiscount ?>
             <div class="cartTotal"><?php echo commas($cart['oldCart']->total() - $totalDiscount) ?>đ</div>
             <?php if($totalDiscount > 0){ ?>
             <div class="subPercent">(Đã giảm <?php echo percent($cart['oldCart']->total(), $cart['oldCart']->total() - $totalDiscount) ?>% trên giá gốc)</div>
            <?php } ?>
          </div>
        </div>
   </div>
</div>
