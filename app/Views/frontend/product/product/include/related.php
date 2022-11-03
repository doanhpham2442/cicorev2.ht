<?php if(isset($productRelate) && is_array($productRelate) && count($productRelate)){ ?>
<div class="klb-module related products" id="related-products">
    <div class="klb-title module-header">
       <h4 class="entry-title">Sản phẩm cùng chuyên mục</h4>
    </div>
    <div class="products uk-grid uk-grid-collapse">
      <?php foreach($productRelate as $key => $val){ ?>
         <?php
            $title = $val['title'];
            $canonical = write_url($val['canonical']);
            $price = getPrice($val, $val['promotion']);
            $review = (int)$val['review']['totalReview'];
            $rate = (int)$val['review']['totalRate'];
            $review = getReview($review, $rate);
            $stock = getStock();
            $image = getthumb($val['image']);

         ?>
       <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-5">
          <div class="product">
             <div class="thumbnail-wrapper">
               <?php if($price['percent'] > 0){ ?>
                  <div class="product-badges"><span class="badge style-1 onsale">-<?php echo $price['percent'] ?>%</span>
                     <span class="badge style-1 recommend">saleoff</span>
                  </div>
               <?php } ?>
                  <a class="image img-cover" href="<?php echo $canonical ?>" title="<?php echo $title; ?>">
                      <img src="<?php echo $image; ?>" />
                  </a>
                  <div class="product-buttons">
                      <a href="430" class="detail-bnt quick-view-button">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                              <path
                                   d="M128 32V0H16C7.163 0 0 7.163 0 16v112h32V54.56L180.64 203.2l22.56-22.56L54.56 32H128zM496 0H384v32h73.44L308.8 180.64l22.56 22.56L480 54.56V128h32V16c0-8.837-7.163-16-16-16zM480 457.44L331.36 308.8l-22.56 22.56L457.44 480H384v32h112c8.837 0 16-7.163 16-16V384h-32v73.44zM180.64 308.64L32 457.44V384H0v112c0 8.837 7.163 16 16 16h112v-32H54.56L203.2 331.36l-22.56-22.72z"
                              />
                           </svg>
                      </a>
                      <div class="add-to-cart add-wishlist" >
                           <a class="fa fa-heart">
                              <span>Add to Wishlist</span>
                           </a>
                      </div>
                  </div>
             </div>
             <div class="content-wrapper">
                  <h3 class="product-title">
                      <a href="<?php echo $canonical; ?>" title="<?php echo $title ?>">
                           <?php echo $title ?>
                      </a>
                  </h3>
                  <div class="product-meta"><div class="product-available in-stock"><?php echo $stock; ?></div></div>
                  <?php echo renderReviewBlock($review); ?>
                  <span class="price">
                     <?php if($price['price'] > 0 && $price['price'] != $price['priceSale']){ ?>
                        <span class="old-price amount mr10">
                             <span><?php echo $price['priceString']; ?></span>
                        </span>
                   <?php } ?>
                      <span class=" amount">
                           <bdi><?php echo ($price['priceSale'] > 0) ? $price['priceSaleString'] : $price['priceString']   ?></bdi>
                      </span>
                  </span>
                  <div class="product-button-group cart-with-quantity">
                      <a class="button-primary xsmall rounded wide button add-cart">Thêm vào giỏ hàng</a>
                  </div>
             </div>
          </div>
       </div>
    <?php } ?>
    </div>
</div>
<?php } ?>
