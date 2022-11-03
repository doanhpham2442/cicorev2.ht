<div class="column">
   <?php $price =  getPrice($product, $product['promotion']); ?>
   <div class="price">
      <?php if($price['price'] > 0 && $price['price'] != $price['priceSale']){ ?>
      <del>
          <span class=" amount mr10" >
              <bdi><?php echo $price['priceString']; ?></bdi>
          </span>
      </del>
    <?php } ?>
       <span class=" amount">
           <bdi><?php echo ($price['priceSale'] > 0) ? $price['priceSaleString'] : $price['priceString']   ?></bdi>
       </span>
   </div>
   <div class="product-meta">
      <?php $stock = getStock(); ?>
       <div class="stock product-available in-stock">
           <span class="stock in-stock"><?php echo $stock; ?></span>
       </div>
   </div>
   <!-- product-meta -->
   <div class=" product-short-description">
       <?php echo $product['description']; ?>
   </div>
   <div class="stock product-available in-stock">
       <span class="stock in-stock">In Stock</span>
   </div>

   <form class="cart" action="" method="post" >
       <div class="quantity">
           <label class="screen-reader-text" for=""><?php echo $product['title']; ?></label>
           <div class="quantity-button minus"><i class="klbth-icon-minus"></i></div>
           <input type="text"  class="input-text qty text quantity" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" />
           <div class="quantity-button plus"><i class="klbth-icon-plus"></i></div>
       </div>

       <button type="submit" name="add-to-cart" value="" class="btn-cart addCart" data-id="<?php echo $product['id'] ?>">Thêm vào giỏ hàng</button>
   </form>

   <button class="woosc-btn woosc-btn-420 addt-to-compare">
       So sánh
   </button>
   <div class="product-actions">
       <button class="tinv-wraper woocommerce tinv-wishlist tinvwl-shortcode-add-to-cart add-to-wishlist" >
           <div class="tinv-wishlist-clear"></div>
           <a  href=""><i class="fa fa-heart"></i></a>
           <div class="tinv-wishlist-clear"></div>
           <div class="tinvwl-tooltip">Thêm vào yêu thích</div>
       </button>
       <button
           class="woosc-btn woosc-btn-420 add-to-compare"
           data-id="420"
           data-product_name="<?php echo $product['title'] ?>"
           data-product_image="<?php echo $product['image']; ?>"
       >
           So sánh
       </button>
   </div>
   <div class="product_meta product-meta bottom">
       <span class="sku_wrapper">SKU: <span class="sku"><?php echo $product['code'] ?></span></span>

       <span class="posted_in">Category: <a href="" rel="tag"><?php echo $productCatalogue['title'] ?></a></span>
   </div>
   <div class="product-share">
       <div class="social-share site-social style-1">
           <ul class="uk-list uk-clearfix uk-flex social-container">
                <li>
                    <a href="<?php echo $general['social_facebook'] ?>" class="facebook"><i class="klbth-icon-facebook"></i></a>
                </li>
                <li>
                    <a href="<?php echo $general['social_twitter'] ?>" class="twitter"><i class="klbth-icon-twitter"></i></a>
                </li>
                <li>
                    <a href="<?php echo $general['social_pinterest'] ?>" class="pinterest"><i class="klbth-icon-pinterest"></i></a>
                </li>
           </ul>
       </div>
   </div>
</div>
