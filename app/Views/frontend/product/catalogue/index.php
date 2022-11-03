<div class="shoppage">
   <div class="shop-content">
        <div class="uk-container uk-container-center">
            <div class="uk-breadcrumb mb30">
                <ul>
                    <li><a href="">Home</a></li>
                    <li>Shop</li>
                </ul>
            </div>
            <div class="uk-grid uk-grid-large ">
                <div  class="uk-width-small-1-1 uk-width-medium-1-4">
                     <?php if(isset($productCatalogueList) && is_array($productCatalogueList) && count($productCatalogueList)){ ?>
                     <?php foreach($productCatalogueList as $key => $val){ ?>
                    <div class="aside-shop">
                        <div class="widget widget-product">
                            <h4 class="widget-title"><?php echo $val['title'] ?></h4>
                            <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                            <div class="widget-body site-checkbox-lists">
                                <div class="site-scroll ps">
                                    <ul>
                                       <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                                        <li class="cat-parent">
                                            <a href="<?php echo write_url($valChild['canonical']) ?>" class="product_cat">
                                                <input
                                                   type="checkbox"
                                                   name="product_catalogue_id"
                                                   value="<?php echo $valChild['id'] ?>"
                                                   id="<?php echo $valChild['canonical'] ?>"
                                                   <?php echo ($valChild['id'] == $productCatalogue['id']) ? 'checked' : '' ?>
                                                />
                                                <label><span></span><?php echo $valChild['title'] ?></label>
                                            </a>
                                            <span class="subDropdown plus"></span>
                                        </li>
                                       <?php } ?>
                                    </ul>
                                </div>
                            </div>
                           <?php } ?>
                        </div>
                        <!--<div class="widget  widget-price-filter">
                            <h4 class="widget-title">Lọc Theo Giá</h4>
                            <form method="get" action="">
                                <div class="price_slider_wrapper">
                                    <div class="price_slider" style="display: none;"></div>
                                    <div class="price_slider_amount" data-step="10">
                                        <input type="text" id="min_price" name="min_price" value="0" data-min="0" placeholder="Min price" />
                                        <input type="text" id="max_price" name="max_price" value="5000000" data-max="5000000" placeholder="Max price" />
                                        <button type="submit" class="button">Filter</button>
                                        <div class="price_label" style="display: none;">Price: <span class="from"></span> &mdash; <span class="to"></span></div>
                                        <input type="hidden" name="on_sale" value="onsale" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="widget widget-product-status">
                            <h4 class="widget-title">Tình Trạng</h4>
                            <div class="widget-body site-checkbox-lists">
                                <div class="site-scroll">
                                    <ul>
                                        <li>
                                            <a href="">
                                                <input value="instock" id="instock" type="checkbox" /><label><span></span>Còn Hàng</label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <input name="stockonsale" value="onsale" id="onsale" type="checkbox" checked /><label><span></span>Hết Hàng</label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <input name="stockonsale" value="onsale" id="onsale" type="checkbox"  /><label><span></span>Đang khuyến mãi</label>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>-->
                        <div class="widget widget-banner">
                            <a class="image img-cover" href="" title=""><img src="public/frontend/resources/img/sidebar-banner.gif"/></a>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-3-4">
                    <div class="shop-banner">
                        <div class="module-banner image align-center align-middle">
                            <div class="module-body">
                                <div class="banner-wrapper">
                                    <div class="banner-content">
                                        <div class="content-main">
                                            <h1 class="entry-subtitle color-text xlight"><?php echo $productCatalogue['title'] ?></h1>
                                            <div class="entry-text color-info-dark"><?php echo $productCatalogue['description']; ?></div>
                                        </div>
                                    </div>
                                    <?php $album = json_decode($productCatalogue['album']); ?>
                                    <div class="banner-thumbnail">
                                       <a href="<?php echo $canonical ?>" title="<?php echo $productCatalogue['title'] ?>" class="image img-cover"> <img src="<?php echo $album[0] ?>" alt="Organic Meals Prepared" /></a>
                                    </div>
                                    <a href="<?php echo $canonical; ?>" class="overlay-link"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="before-shop-loop">
                        <div class="woocommerce-ordering product-filter" method="get">
                            <span class="orderby-label hide-desktop">Sắp xếp</span>
                            <select name="orderby" class="orderby filterSelect" aria-label="Shop order" data-class="select-filter-orderby">
                               <option value="">Sắp xếp sản phẩm</option>
                                <option value="popularity">Phổ biến nhất</option>
                                <option value="date">Sản phẩm mới</option>
                                <option value="price|desc">Giá từ cao đến thấp</option>
                                <option value="price|asc">Giá từ thấp đến cao</option>
                            </select>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>


                        <!-- For perpage option-->
                        <div class="products-per-page product-filter" method="get">
                            <span class="perpage-label">Show</span>
                            <select name="perpage" class="perpage filterSelect" data-class="select-filter-perpage">
                               <?php for($i = 12; $i<= 72; $i+= 12){ ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                              <?php } ?>
                            </select>
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                    </div>

                    <ul class="remove-filter">
                        <li><a href="" class="remove-filter-element clear-all">Clear filters</a></li>
                        <li><a href="" class="remove-filter-element on_sale">On Sale</a></li>
                    </ul>
                    <?php if(isset($product['list']) && is_array($product['list']) && count($product['list'])){ ?>
                    <div class="shop-page-product">
                        <div class="products uk-grid uk-grid-collapse">
                           <?php foreach($product['list'] as $key => $val){ ?>
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
                            <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
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
                                            <a class="button-primary xsmall rounded wide button add-cart">Add to cart</a>
                                       </div>
                                  </div>
                               </div>
                            </div>
                           <?php } ?>
                        </div>
                    </div>
                  <?php } ?>
                    <nav class="woocommerce-pagination">
                        <?php echo (isset($product['pagination'])) ? $product['pagination']  : ''; ?>
                    </nav>
                </div>
            </div>
        </div>
   </div>
</div>
