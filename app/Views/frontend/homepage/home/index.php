<div class="homepage">
    <div class="site-content">
      <div class="homepage-content">
           <div class="uk-container uk-container-center" >
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-small-1-1 uk-width-medium-1-4" >
                       <div class="aside-homepage">
                           <div class="aside-empty mb20"></div>
                           <?php if(isset($asideBanner) && is_array($asideBanner) && count($asideBanner)){ ?>
                           <?php foreach($asideBanner as $key => $val){ ?>
                           <div class="aside-homepage-banner mb20">
                                <div class="module-banner image align-left align-top full-text">
                                    <div class="banner-wrapper">
                                        <div class="banner-content">
                                           <div class="content-header"><div class="sub-text color-white"><?php echo $val['slide_title'] ?></div></div>
                                           <div class="content-main">
                                               <h4 class="entry-subtitle color-text small xlight"><?php echo $val['slide_description'] ?></h4>
                                           </div>
                                        </div>
                                        <div class="banner-thumbnail"><a class="image img-cover" href="<?php echo $val['canonical'] ?>" title="<?php echo $val['title'] ?>"><img src="<?php echo $val['image'] ?>" alt="banner" /></a></div>
                                        <a href="<?php echo $val['canonical'] ?>" class="overlay-link"></a>
                                    </div>
                                </div>
                           </div>
                           <?php }} ?>
                           <div class="aside-benefit mb20">
                                <div class="iconboxes-widget">
                                    <div class="item">
                                        <div class="icon"><i class="klbth-icon-download"></i></div>
                                        <div class="text">Tải <?php echo $general['homepage_brand'] ?> App cho điện thoại của bạn.</div>
                                    </div>
                                    <div class="item">
                                        <div class="icon"><i class="klbth-icon-delivery-box-1"></i></div>
                                        <div class="text">Đặt hàng ngay để không bỏ lỡ cơ ưu đãi lớn nhất.</div>
                                    </div>
                                    <div class="item">
                                        <div class="icon"><i class="klbth-icon-clock"></i></div>
                                        <div class="text">Đơn hàng của bạn sẽ đến tận nơi sau 15 phút.</div>
                                    </div>
                                </div>
                           </div>
                           <?php if(isset($widget['trending']) && is_array($widget['trending']) && count($widget['trending'])){ ?>
                           <div class="aside-trending mb20">
                                <h4 class="widget-title"><?php echo $widget['trending']['title'] ?></h4>
                                <?php if(isset($widget['trending']['object']) && is_array($widget['trending']['object']) && count($widget['trending']['object'])){ ?>
                                <div class="products products-list">
                                   <?php foreach($widget['trending']['object'] as $key => $val){  ?>
                                      <?php
                                          $title = $val['title'];
                                          $canonical = write_url($val['canonical']);
                                          $price = getPrice($val, $val['promotion']);
                                          $review = (int)$val['review']['totalReview'];
                                          $rate = (int)$val['review']['totalRate'];
                                          $review = getReview($review, $rate);
                                          $stock = getStock($val['id']);
                                          $image = $val['image'];
                                      ?>
                                    <div class="product product-type-simple">
                                        <div class="product-wrapper">
                                           <div class="thumbnail-wrapper">
                                               <a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>">
                                                    <img src="<?php echo $image; ?>" alt="<?php echo $title ?>" />
                                               </a>
                                           </div>
                                           <div class="content-wrapper">
                                               <h3 class="product-title"><a href=""><?php echo $title ?></a></h3>
                                               <div class="product-meta"></div>
                                               <span class="price">
                                                 <?php if($price['price'] > 0 && $price['price'] != $price['priceSale']){ ?>
                                                  <del>
                                                      <span class=" amount">
                                                          <bdi><?php echo $price['priceString']; ?></bdi>
                                                      </span>
                                                  </del>
                                                <?php } ?>
                                                   <span class=" amount">
                                                      <bdi><?php echo ($price['priceSale'] > 0) ? $price['priceSaleString'] : $price['priceString']   ?></bdi>
                                                   </span>
                                              </span>
                                           </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                 <?php } ?>
                           </div>
                           <?php } ?>
                           <?php if(isset($widget['feedback']) && is_array($widget['feedback']) && count($widget['feedback'])){ ?>
                           <div class="aside-testimonial">
                                <h4 class="widget-title"><?php echo $widget['feedback']['title'] ?></h4>
                                <?php if(isset($widget['feedback']['object']) && is_array($widget['feedback']['object']) && count($widget['feedback']['object'])){ ?>
                                 <?php foreach($widget['feedback']['object'] as $key => $val){ ?>
                                <div class="customer-comment">
                                    <h4 class="entry-title"><?php echo strip_tags($val['description']) ?></h4>
                                    <div class="entry-message"><?php echo strip_tags($val['content']) ?></div>
                                    <div class="customer">
                                        <div class="avatar"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>" /></div>
                                        <div class="detail">
                                           <h3 class="customer-name"><?php echo $val['title'] ?></h3>
                                           <span class="customer-mission">Khách Hàng</span>
                                        </div>
                                    </div>
                                </div>
                              <?php }} ?>
                           </div>
                           <?php } ?>
                       </div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-3-4" >
                       <?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
                       <div class="content-homepage">
                           <div class="panel-slide mb20">
                                <div class="uk-slidenav-position" data-uk-slideshow="{animation: 'scroll'}">
                                    <?php
                                        $target = 'animated';
                                        $animated1 = 'fadeInLeft';
                                        $animated2 = 'fadeInRight';
                                        $animated3 = 'fadeInUp';
                                        $animated4 = 'fadeInDown';

                                    ?>
                                    <ul class="uk-slideshow">
                                       <?php foreach($slide as $key => $val){ ?>
                                        <li>
                                           <div class="slider-item">
                                               <div class="content-wrapper">
                                                    <div class="content-header">
                                                        <div class="content-description"><?php echo $val['slide_title'] ?></div>
                                                    </div>
                                                    <div class="content-main">
                                                        <h3 class="entry-title"><?php echo $val['slide_description']; ?></h3>
                                                    </div>
                                                    <a href="<?php echo $val['canonical'] ?>" class="button button-secondary rounded" tabindex="0">Shop Now <i class="klbth-icon-right-arrow"></i></a>
                                               </div>
                                               <div class="image-wrapper"><a class="image img-cover" href="<?php echo $val['canonical'] ?>" title="<?php echo $val['slide_title'] ?>"><img src="<?php echo $val['image']; ?>" alt="<?php echo $val['slide_title'] ?>" /></a></div>
                                           </div>
                                        </li>
                                       <?php } ?>
                                    </ul>
                                    <!-- <a href="" class="uk-slidenav  uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                                    <a href="" class="uk-slidenav  uk-slidenav-next" data-uk-slideshow-item="next"></a> -->
                                    <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-left">
                                        <li data-uk-slideshow-item="0"><a href=""></a></li>
                                        <li data-uk-slideshow-item="1"><a href=""></a></li>
                                    </ul>
                                </div>
                           </div>
                           <?php if(isset($widget['bestSeller']) && is_array($widget['bestSeller']) && count($widget['bestSeller'])){ ?>
                           <div class="panel-best-product mb20">
                                <?php
                                    $owlInit = [
                                        'nav' => true,
                                        'dots' => false,
                                        'loop' => true,
                                        'margin' => 0,
                                        'responsive' => array(
                                           0 => array(
                                               'items' => 1,
                                           ),
                                           480 => array(
                                               'items' => 2,
                                           ),
                                           768 => array(
                                               'items' => 2,
                                           ),
                                           960 => array(
                                               'items' => 4,
                                           ),
                                        ),
                                    ];
                                ?>
                                <div class="panel-head mb20 uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="info">
                                        <h4 class="title"><span><?php echo $widget['bestSeller']['title']; ?></span></h4>
                                        <div class="description"><?php echo $widget['bestSeller']['description'] ?></div>
                                    </div>
                                </div>
                                <?php if(isset($widget['bestSeller']['object']) && is_array($widget['bestSeller']['object']) && count($widget['bestSeller']['object'])){ ?>
                                <div class="panel-body">
                                    <div class="owl-slide">
                                        <div class="owl-carousel owl-themes" data-owl="<?php echo base64_encode(json_encode($owlInit)); ?>">
                                          <?php foreach($widget['bestSeller']['object'] as $product){ ?>
                                          <?php
                                             $title = $product['title'];
                                             $canonical = write_url($product['canonical']);
                                             $price = getPrice($product, $product['promotion']);
                                             $review = (int)$product['review']['totalReview'];
                                             $rate = (int)$product['review']['totalRate'];
                                             $review = getReview($review, $rate);
                                             $stock = getStock($product['id']);

                                          ?>
                                           <div class="products">
                                               <div class="thumbnail-wrapper">
                                                 <?php if($price['percent'] > 0){ ?>
                                                    <div class="product-badges"><span class="badge style-1 onsale">-<?php echo $price['percent'] ?>%</span>
                                                       <span class="badge style-1 recommend">saleoff</span>
                                                    </div>
                                                 <?php } ?>
                                                    <a class="image img-cover" href="<?php echo $canonical ?>" title="<?php echo $title; ?>">
                                                        <img src="<?php echo getthumb($product['image']); ?>" />
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
                                                   <?php echo renderReviewBlock($review) ?>
                                                    <span class="price">
                                                       <?php if($price['price'] > 0 && $price['price'] != $price['priceSale']){ ?>
                                                       <del>
                                                           <span class=" amount">
                                                               <bdi><?php echo $price['priceString']; ?></bdi>
                                                           </span>
                                                       </del>
                                                     <?php } ?>
                                                        <span class=" amount">
                                                            <bdi><?php echo ($price['priceSale'] > 0) ? $price['priceSaleString'] : $price['priceString']   ?></bdi>
                                                        </span>
                                                    </span>
                                                    <div class="product-button-group cart-with-quantity">
                                                        <a class="button-primary xsmall rounded wide button addCart" data-id="<?php echo $product['id'] ?>">Thêm vào giỏ hàng</a>
                                                    </div>
                                               </div>
                                           </div>
                                          <?php } ?>


                                        </div>
                                    </div>
                                </div>
                                 <?php } ?>
                           </div>
                           <?php } ?>
                           <div class="panel-banner mb20">
                                <div class="site-module module-banner wide">
                                    <div class="module-body">
                                        <div class="banner-wrapper">
                                           <div class="banner-content">
                                               <h4 class="sub-text color-info-dark">Always Taking Care</h4>
                                               <h3 class="entry-title mini color-text-lighter">In store or online your health &amp; safety is our top priority.</h3>
                                           </div>
                                           <div class="banner-thumbnail"><a class="image img-cover" href="" title=""><img src="public/frontend/resources/img/banner-box2.jpg" alt="banner" /></a></div>
                                           <a href="" class="overlay-link"></a>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="panel-hot-product mb20 uk-hidden">
                                <div class="site-module module-hot-product">
                                    <div class="module-header">
                                        <div class="column">
                                           <h4 class="entry-title">HOT PRODUCT FOR <span>THIS WEEK</span></h4>
                                           <div class="entry-description">Dont miss this opportunity at a special discount just for this week.</div>
                                        </div>
                                        <div class="column">
                                           <a href="" class="button button-info-default xsmall rounded">View All <i class="klbth-icon-right-arrow"></i></a>
                                        </div>
                                        <!-- column -->
                                    </div>
                                    <!-- module-header -->
                                    <div class="module-body">
                                        <div class="hot-product products">
                                           <div class="product">
                                               <div class="hot-sale">19%</div>
                                               <div class="product-wrapper">
                                                    <div class="thumbnail-wrapper">
                                                        <a href="" title="Chobani Complete Vanilla Greek Yogurt">
                                                            <img src="public/frontend/resources/img/product-image-50.jpg" alt="Chobani Complete Vanilla Greek Yogurt" />
                                                        </a>
                                                    </div>
                                                    <div class="content-wrapper">
                                                        <div class="hot-product-header">
                                                            <span class="price">
                                                                <del>
                                                                    <span class=" amount">
                                                                        <bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>5.49</bdi>
                                                                    </span>
                                                                </del>

                                                                    <span class=" amount">
                                                                        <bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>4.49</bdi>
                                                                    </span>

                                                            </span>
                                                        </div>
                                                        <h3 class="product-title"><a href="">Chobani Complete Vanilla Greek Yogurt</a></h3>
                                                        <div class="product-meta">
                                                            <div class="product-unit">1 kg</div>
                                                            <div class="product-available in-stock">In Stock</div>
                                                        </div>
                                                        <div class="product-progress"><span class="progress" style="width: 82%;"></span></div>
                                                        <div class="product-expired">
                                                            <div class="countdown" data-date="2022/10/13">
                                                                <div class="count-item days"></div>
                                                                <span>:</span>
                                                                <div class="count-item hours"></div>
                                                                <span>:</span>
                                                                <div class="count-item minutes"></div>
                                                                <span>:</span>
                                                                <div class="count-item second"></div>
                                                            </div>
                                                            <div class="expired-text">Remains until the end of the offer</div>
                                                        </div>
                                                    </div>
                                               </div>
                                               <a href="" title="Chobani Complete Vanilla Greek Yogurt" class="overlay-link"></a>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="panel-discount mb20 uk-hidden">
                                <div class="site-module discount-item">
                                    <a href="">
                                        <span class="purchase-text">Super discount for your <strong>first purchase.</strong></span><span class="purchase-code">FREE25BAC</span>
                                        <span class="purchase-description">Use discount code in checkout!</span>
                                    </a>
                                </div>
                           </div>
                           <?php if(isset($widget['newProduct']) && is_array($widget['newProduct']) && count($widget['newProduct'])){ ?>
                           <div class="panel-new-product mb30">
                                <div class="site-module module-products">
                                    <div class="module-header">
                                        <div class="column">
                                           <h4 class="entry-title"><?php echo $widget['newProduct']['title'] ?></h4>
                                           <div class="entry-description"><?php echo $widget['newProduct']['description'] ?></div>
                                        </div>
                                    </div>
                                    <?php if(isset($widget['newProduct']['object']) && is_array($widget['newProduct']['object']) && count($widget['newProduct']['object'])){ ?>
                                    <div class="module-body">
                                        <div class="products uk-grid uk-grid-collapse">
                                           <?php foreach($widget['newProduct']['object'] as $product){ ?>
                                           <?php
                                              $title = $product['title'];
                                              $canonical = write_url($product['canonical']);
                                              $price = getPrice($product, $product['promotion']);
                                              $review = (int)$product['review']['totalReview'];
                                              $rate = (int)$product['review']['totalRate'];
                                              $review = getReview($review, $rate);
                                              $stock = getStock();
                                           ?>
                                           <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                                               <div class="product ">
                                                    <div class="product-wrapper product-type-1">
                                                        <div class="thumbnail-wrapper">
                                                           <?php if($price['percent'] > 0){ ?>
                                                              <div class="product-badges"><span class="badge style-1 onsale">-<?php echo $price['percent'] ?>%</span>
                                                                 <span class="badge style-1 recommend">saleoff</span>
                                                              </div>
                                                           <?php } ?>
                                                            <a class="image img-cover" href="<?php echo $canonical; ?>" title="<?php echo $product['title'] ?>">
                                                                <img src="<?php echo $product['image'] ?>" alt="All Natural Italian-Style Chicken Meatballs" />
                                                            </a>
                                                            <div class="product-buttons">
                                                                <a href="430" class="detail-bnt quick-view-button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <path
                                                                            d="M128 32V0H16C7.163 0 0 7.163 0 16v112h32V54.56L180.64 203.2l22.56-22.56L54.56 32H128zM496 0H384v32h73.44L308.8 180.64l22.56 22.56L480 54.56V128h32V16c0-8.837-7.163-16-16-16zM480 457.44L331.36 308.8l-22.56 22.56L457.44 480H384v32h112c8.837 0 16-7.163 16-16V384h-32v73.44zM180.64 308.64L32 457.44V384H0v112c0 8.837 7.163 16 16 16h112v-32H54.56L203.2 331.36l-22.56-22.72z"
                                                                        />
                                                                    </svg>
                                                                </a>
                                                                <div class="add-to-cart" >
                                                                    <a class="fa fa-heart add-wishlist">
                                                                        <span>Add to Wishlist</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="content-wrapper">
                                                            <h3 class="product-title">
                                                                <a href="<?php echo $canonical ?>" title="<?php echo $title; ?>">
                                                                    <?php echo $title; ?>
                                                                </a>
                                                            </h3>
                                                            <div class="product-meta"><div class="product-available in-stock"><?php echo $stock; ?></div></div>
                                                            <?php echo renderReviewBlock($review); ?>
                                                            <span class="price">
                                                               <?php if($price['price'] > 0 && $price['price'] != $price['priceSale']){ ?>
                                                                <del>
                                                                    <span class=" amount">
                                                                        <bdi><?php echo $price['priceString']; ?></bdi>
                                                                    </span>
                                                                </del>
                                                              <?php } ?>
                                                                <span class=" amount">
                                                                    <bdi><?php echo ($price['priceSale'] > 0) ? $price['priceSaleString'] : $price['priceString']   ?></bdi>
                                                                </span>
                                                            </span>
                                                            <div class="product-fade-block">
                                                                <div class="product-button-group cart-with-quantity">
                                                                    <a href="" class="button-primary xsmall rounded wide button add-cart addCart" data-id="<?php echo $product['id'] ?>">
                                                                        Thêm vào giỏ hàng
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-fade border-info"></div>
                                               </div>
                                           </div>
                                          <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                           </div>
                           <?php } ?>
                           <div class="panel-week-discount">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                           <div
                                               class="elementor-element elementor-element-2da7cde elementor-widget elementor-widget-bacola-banner-box3"
                                               data-id="2da7cde"
                                               data-element_type="widget"
                                               data-widget_type="bacola-banner-box3.default"
                                           >
                                               <div class="elementor-widget-container">
                                                    <div class="site-module module-banner image align-left align-center">
                                                        <div class="module-body">
                                                            <div class="banner-wrapper">
                                                                <div class="banner-content">
                                                                    <div class="content-header"><div class="discount-text color-success">Weekend Discount 40%</div></div>
                                                                    <div class="content-main">
                                                                        <h3 class="entry-title color-text-light">Legumes &amp; Cereals</h3>
                                                                        <div class="entry-text color-info-dark">Feed your family the best</div>
                                                                    </div>
                                                                    <a href="https://klbtheme.com/bacola/product/blue-diamond-almonds-lightly-salted/" class="button button-info-dark rounded xsmall">Shop Now</a>
                                                                </div>
                                                                <div class="banner-thumbnail"><img src="https://k4j3j2s7.rocketcdn.me/bacola/wp-content/uploads/2021/08/bacola-banner-01.jpg" alt="banner" /></div>
                                                                <a href="https://klbtheme.com/bacola/product/blue-diamond-almonds-lightly-salted/" class="overlay-link"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                           <div
                                               class="elementor-element elementor-element-443c6d2 elementor-widget elementor-widget-bacola-banner-box3"
                                               data-id="443c6d2"
                                               data-element_type="widget"
                                               data-widget_type="bacola-banner-box3.default"
                                           >
                                               <div class="elementor-widget-container">
                                                    <div class="site-module module-banner image align-left align-center">
                                                        <div class="module-body">
                                                            <div class="banner-wrapper">
                                                                <div class="banner-content">
                                                                    <div class="content-header"><div class="discount-text color-success">Weekend Discount 40%</div></div>
                                                                    <div class="content-main">
                                                                        <h3 class="entry-title color-text-light">Dairy &amp; Eggs</h3>
                                                                        <div class="entry-text color-info-dark">A different kind of grocery store</div>
                                                                    </div>
                                                                    <a href="https://klbtheme.com/bacola/product/organic-cage-free-grade-a-large-brown-eggs/" class="button button-info-dark rounded xsmall">Shop Now</a>
                                                                </div>
                                                                <div class="banner-thumbnail"><img src="https://k4j3j2s7.rocketcdn.me/bacola/wp-content/uploads/2021/08/bacola-banner-02.jpg" alt="banner" /></div>
                                                                <a href="https://klbtheme.com/bacola/product/organic-cage-free-grade-a-large-brown-eggs/" class="overlay-link"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                       </div>
                        <?php } ?>
                    </div>
                </div>
           </div>
           <?php if(isset($widget['categories']) && is_array($widget['categories']) && count($widget['categories'])){ ?>
           <div class="panel-category mt30">
                <div class="uk-container uk-container-center">
                    <div class="elementor-element">
                       <div class="site-module module-category style-1">
                           <div class="module-body">
                                <div class="categories">
                                   <?php foreach($widget['categories']['object'] as $key => $val){ ?>
                                     <?php
                                       $title = $val['title'];
                                       $canonical = write_url($val['canonical']);
                                       $totalItem = $val['totalProduct'];
                                     ?>
                                     <?php if($key > 0) break; ?>
                                    <div class="first">
                                        <div class="category">
                                           <div class="category-image">
                                               <a class="image img-scaledown" href="<?php echo $canonical; ?>" title="<?php echo $title; ?>">
                                                    <img src="<?php echo $val['image']; ?>" alt="<?php echo $title; ?>" />
                                               </a>
                                           </div>
                                           <div class="category-detail">
                                               <h3 class="entry-category"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
                                               <div class="category-count"><?php echo $totalItem; ?> Sản phẩm</div>
                                           </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="categories-wrapper">
                                       <?php foreach($widget['categories']['object'] as $key => $val){ ?>
                                         <?php
                                           $title = $val['title'];
                                           $canonical = write_url($val['canonical']);
                                           $totalItem = $val['totalProduct'];
                                         ?>
                                         <?php if($key == 0) continue; ?>
                                        <div class="category">
                                           <div class="category-image">
                                               <a class="image img-scaledown" href="<?php echo $canonical; ?>" title="<?php echo $title; ?>">
                                                    <img src="<?php echo $val['image'] ?>" alt="<?php echo $title; ?>" />
                                               </a>
                                           </div>
                                           <div class="category-detail">
                                               <h3 class="entry-category"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
                                               <div class="category-count"><?php echo $totalItem; ?> Sản phẩm</div>
                                           </div>
                                        </div>
                                       <?php } ?>
                                    </div>
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
           </div>
         <?php } ?>
      </div>
    </div>
</div>
