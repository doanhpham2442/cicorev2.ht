<?php echo view(route('frontend.homepage.common.canvas')) ?>

<header id="masthead" class="site-header desktop-shadow-disable mobile-shadow-enable mobile-nav-enable" itemscope="itemscope" itemtype="">
    <div class="header-top header-wrapper hide-mobile">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="column column-left">
                    <nav class="site-menu horizontal">
                        <ul id="menu-top-left" class="menu">
                            <li id="menu-item-1893" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1893"><a href="<?php echo write_url('gioi-thieu') ?>">Giới thiệu</a></li>
                            <li id="menu-item-1892" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1892"><a href="<?php echo write_url('login') ?>">Tài khoản</a></li>
                            <li id="menu-item-1891" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1891"><a href="<?php echo write_url('wishlist') ?>">Yêu thích</a></li>
                            <li id="menu-item-1890" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1890"><a href="<?php echo write_url('check-order') ?>">Kiểm tra đơn hàng</a></li>
                        </ul>
                    </nav>
                    <!-- site-menu -->
                </div>
                <div class="column column-right">
                    <div class="topbar-notice">
                        <i class="klbth-icon-secure"></i>
                        <span><?php echo $general['homepage_slogan'] ?></span>
                    </div>

                    <div class="text-content">
                        Cần giúp đỡ? Gọi chúng tôi: <a href="tel:<?php echo $general['contact_hotline'] ?>"><strong style="color: #2bbef9;"><?php echo $general['contact_hotline'] ?></strong></a>
                    </div>

                    <div class="header-switchers">
                        <nav class="store-language site-menu horizontal">
                            <ul id="menu-top-right-1" class="menu">
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1832">
                                    <a href="#">Vietnamese</a>
                                    <!--<ul class="sub-menu">
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1838"><a href="#">Vietnamese</a></li>
                                    </ul>-->
                                </li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1835">
                                    <a href="#">VND</a>
                                    <!--<ul class="sub-menu">
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1839"><a href="#">USD</a></li>
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1836"><a href="#">INR</a></li>
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1837"><a href="#">GBP</a></li>
                                    </ul>-->
                                </li>
                            </ul>
                        </nav>
                        <!-- site-menu -->
                    </div>
                    <!-- header-switchers -->
                </div>
            </div>
            <!-- column-right -->
        </div>
        <!-- container -->
    </div>
    <!-- header-top -->

    <div class="header-main header-wrapper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="column column-left">
                    <div class="header-buttons hide-desktop">
                        <div class="header-canvas button-item">
                            <a href="#">
                                <i class="klbth-icon-menu-thin"></i>
                            </a>
                        </div>
                        <!-- button-item -->
                    </div>
                    <!-- header-buttons -->
                    <div class="site-brand">
                        <a class="image img-cover" href="" title="Bacola &#8211; Grocery Market and Food Theme">
                            <img class="desktop-logo hide-mobile" src="<?php echo $general['homepage_logo'] ?>" alt="<?php echo $general['seo_meta_title'] ?>" />

                            <img class="mobile-logo hide-desktop" src="<?php echo $general['homepage_logo'] ?>" alt="<?php echo $general['seo_meta_title'] ?>" alt="<?php echo $general['homepage_logo'] ?>" alt="<?php echo $general['seo_meta_title'] ?>" />
                            <span class="brand-description">Trung tâm mua sắm trực tuyến</span>
                        </a>
                    </div>
                    <!-- site-brand -->
                </div>
                <!-- column -->
                <div class="column column-center">
                    <div class="header-location site-location hide-mobile">
                        <a href="#" >
                            <span class="location-description">Your Location</span>
                            <div class="current-location">Select a Location</div>
                        </a>
                    </div>
                    <div class="header-search">
                        <div class="dgwt-wcas-search-wrapp dgwt-wcas-no-submit woocommerce dgwt-wcas-style-solaris js-dgwt-wcas-layout-classic dgwt-wcas-layout-classic js-dgwt-wcas-mobile-overlay-enabled">
                            <form class="dgwt-wcas-search-form" role="search" action="<?php echo write_url('tim-kiem') ?>" method="get">
                                <div class="dgwt-wcas-sf-wrapp">
                                    <svg
                                        version="1.1"
                                        class="dgwt-wcas-ico-magnifier"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px"
                                        y="0px"
                                        viewBox="0 0 51.539 51.361"
                                        enable-background="new 0 0 51.539 51.361"
                                        xml:space="preserve"
                                    >
                                        <path
                                            fill="#444"
                                            d="M51.539,49.356L37.247,35.065c3.273-3.74,5.272-8.623,5.272-13.983c0-11.742-9.518-21.26-21.26-21.26 S0,9.339,0,21.082s9.518,21.26,21.26,21.26c5.361,0,10.244-1.999,13.983-5.272l14.292,14.292L51.539,49.356z M2.835,21.082 c0-10.176,8.249-18.425,18.425-18.425s18.425,8.249,18.425,18.425S31.436,39.507,21.26,39.507S2.835,31.258,2.835,21.082z"
                                        />
                                    </svg>
                                    <input type="search" class="dgwt-wcas-search-input ajaxSearch" name="keyword" value="" placeholder="Tìm kiếm sản phẩm..." autocomplete="off" />

                                </div>
                            </form>
                        </div>
                        <div class="ajaxSearchResult">
                           
                        </div>
                    </div>
                </div>
                <div class="column column-right">
                    <div class="header-buttons">
                        <div class="header-login button-item bordered">
                            <a href="">
                                <div class="button-icon"><i class="klbth-icon-user"></i></div>
                            </a>
                        </div>

                        <div class="header-cart button-item bordered">
                            <a href="">
                                <div class="cart-price">
                                    <span class="woocommerce-Price-amount amount">
                                        <bdi><span class="woocommerce-Price-currencySymbol"></span><span class="cartTotal"><?php echo commas($cart['oldCart']->total()) ?></span> đ</bdi>
                                    </span>
                                </div>
                                <div class="button-icon"><i class="klbth-icon-shopping-bag"></i></div>
                                <span class="cart-count-icon cartItem"><?php echo $cart['oldCart']->totalItems() ?></span>
                            </a>
                            <div class="cart-dropdown hide">
                                <div class="cart-dropdown-wrapper">
                                    <div class="fl-mini-cart-content">
                                        <div class="cart-empty">
                                           <?php if(isset($cart['newCart']) && is_array($cart['newCart']) && count($cart['newCart']) ){ ?>
                                           <div class="fl-mini-cart-content" style="opacity: 1;">
                                               <div class="products woocommerce-mini-cart cart_list product_list_widget">
                                                   <div class="product woocommerce-mini-cart-item mini_cart_item">
                                                      <?php foreach($cart['newCart'] as $key => $val){ ?>
                                                      <?php
                                                         $title = $val['detail']['title'];
                                                         $canonical = write_url($val['detail']['canonical']);
                                                         $quantity = $val['qty'];
                                                         $price = commas($val['price']);
                                                         $image = getthumb($val['detail']['image']);
                                                      ?>
                                                       <div class="product-wrapper <?php echo $key; ?>">
                                                           <div class="thumbnail-wrapper">
                                                               <a href="<?php echo $canonical ?>">
                                                                   <img width="90" height="90" src="<?php echo $image; ?>"class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?php echo $title ?>"/>
                                                               </a>
                                                           </div>
                                                           <!-- humbnail-wrapper -->
                                                           <div class="content-wrapper">
                                                               <h3 class="product-title"><a href="<?php echo $canonical ?>"><?php echo $title; ?></a></h3>
                                                               <div class="entry-price">
                                                                   <span class="quantity">
                                                                       <?php echo $quantity; ?> ×
                                                                       <span class="woocommerce-Price-amount amount">
                                                                           <bdi><span class="woocommerce-Price-currencySymbol"></span><?php echo $price; ?> đ</bdi>
                                                                       </span>
                                                                   </span>
                                                               </div>
                                                               <!-- entry-price -->
                                                               <a
                                                                   href=""
                                                                   class="remove remove_from_cart_button removeCartItem"
                                                                   data-rowid="<?php echo $key; ?>"
                                                               >
                                                                   <i class="klbth-icon-cancel"></i>
                                                               </a>
                                                           </div>
                                                           <!-- content-wrapper -->
                                                       </div>
                                                      <?php } ?>
                                                       <!-- product-wrapper -->
                                                   </div>
                                                   <!-- product -->
                                               </div>

                                               <p class="woocommerce-mini-cart__total total">
                                                   <strong>Tổng Tiền:</strong>
                                                   <span class="woocommerce-Price-amount amount">
                                                       <bdi><span class="woocommerce-Price-currencySymbol"></span><?php echo commas($cart['oldCart']->total()) ?>đ</bdi>
                                                   </span>
                                               </p>
                                               <p class="woocommerce-mini-cart__buttons buttons">
                                                 <a href="<?php echo write_url('gio-hang') ?>" class="button wc-forward">Xem giỏ hàng</a>
                                                 <a href="<?php echo write_url('thanh-toan') ?>" class="button checkout wc-forward">Thanh toán</a>
                                              </p>
                                           </div>
                                          <?php }else{ ?>
                                           <!-- empty-icon -->
                                           <div class="empty-text">Không có sản phẩm trong giỏ hàng.</div>
                                          <?php } ?>
                                        </div>
                                        <!-- cart-empty -->
                                    </div>

                                    <div class="cart-noticy">
                                        Miễn phí vận chuyển cho đơn hàng lớn hơn 500.000vnđ!
                                    </div>
                                    <!-- cart-noticy -->
                                </div>
                                <!-- cart-dropdown-wrapper -->
                            </div>
                            <!-- cart-dropdown -->
                        </div>
                        <!-- button-item -->
                    </div>
                    <!-- header-buttons -->
                </div>
            </div>
            <!-- column -->
        </div>
        <!-- container -->
    </div>
    <!-- header-main -->

    <div class="header-nav header-wrapper hide-mobile">
        <div class="container">
            <?php if(isset($productCatalogueList) && is_array($productCatalogueList) && count($productCatalogueList)){ ?>
            <?php foreach($productCatalogueList as $key => $val){ ?>
            <div class="all-categories locked">
                <a href="#" data-toggle="collapse" data-target="#all-categories">
                    <i class="klbth-icon-menu-thin"></i>
                    <span class="text">DANH MỤC <?php echo $val['title'] ?></span>
                    <div class="description">TỔNG <?php echo $product['count'] ?> SẢN PHẨM</div>
                </a>
               <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                <div class="dropdown-categories collapse <?php echo (isset($seo['module'])) ? 'show' : ''; ?>" id="all-categories">
                    <ul id="menu-sidebar-menu-1" class="menu-list">
                       <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                        <li class="category-parent parent menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children">
                            <a href="<?php echo write_url($valChild['canonical']) ?>" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['icon'] ?><?php echo $valChild['title'] ?></a>
                            <?php if(isset($valChild['children']) && is_array($valChild['children']) && count($valChild['children'])){ ?>
                            <ul class="sub-menu">
                               <?php foreach($valChild['children'] as $keyChildS => $valChildS) ?>
                                <li class="category-parent menu-item menu-item-type-taxonomy menu-item-object-product_cat">
                                    <a href="<?php echo write_url($valChildS['canonical']) ?>"><?php echo $valChildS['title'] ?></a>
                                </li>

                            </ul>
                           <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
               <?php } ?>
            </div>
            <?php }} ?>
            <?php $menu = get_menu(['keyword' => 'main-menu', 'language' => 2, 'output' => 'array' ]);  ?>
            <?php if(isset($menu) && is_array($menu) && count($menu)){ ?>
            <nav class="site-menu primary-menu horizontal">
                <ul id="menu-menu-2" class="menu">
                   <?php foreach($menu['data'] as $key => $val){ ?>
                    <li class="dropdown menu-item menu-item-type-custom menu-item-object-custom  current_page_item menu-item-home current-menu-ancestor current-menu-parent <?php echo (isset($val['children']) && is_array($val['children']) && count($val['children'])) ? 'menu-item-has-children'  : '' ?>">
                        <a href="<?php echo write_url($val['canonical']) ?>"><?php echo $val['title'] ?></a>
                        <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                        <ul class="sub-menu">
                           <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-50 current_page_item"><a href="<?php echo write_url($valChild['canonical']) ?>"><?php echo $valChild['title'] ?></a></li>
                           <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                  <?php } ?>
                </ul>
            </nav>
            <?php } ?>
            <!-- site-menu -->
        </div>
        <!-- container -->
    </div>
    <!-- header-nav -->

    <nav class="header-mobile-nav">
        <div class="mobile-nav-wrapper">
            <ul>
                <li class="menu-item">
                    <a href="" class="store">
                        <i class="klbth-icon-store"></i>
                        <span>Store</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="search">
                        <i class="klbth-icon-search"></i>
                        <span>Search</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="" class="wishlist">
                        <i class="klbth-icon-heart-1"></i>
                        <span>Wishlist</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="" class="user">
                        <i class="klbth-icon-user"></i>
                        <span>Account</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#" class="categories">
                        <i class="klbth-icon-menu-thin"></i>
                        <span>Categories</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- mobile-nav-wrapper -->
    </nav>
    <!-- header-mobile-nav -->
</header>
<!-- site-header -->
<?php if(isset($province) && is_array($province) && count($province)){ ?>
<div class="select-location">
    <div class="select-location-wrapper">
        <h6 class="entry-title">Chọn vị trí của bạn</h6>
        <div class="entry-description">Nhập địa chỉ của bạn và chúng tôi sẽ chỉ định ưu đãi cho khu vực của bạn.</div>
        <div class="close-popup"><i class="klbth-icon-x"></i></div>
        <!-- close-popup -->
        <div class="search-location">
            <select name="site-area" class="select2">
                <?php foreach($province as $key => $val){ ?>
                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
               <?php } ?>
            </select>
        </div>
        <!-- search-location -->
    </div>

    <!-- select-location-wrapper -->
    <div class="location-overlay"></div>
</div>
<?php } ?>
