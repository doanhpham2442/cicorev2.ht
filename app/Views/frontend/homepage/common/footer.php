<footer class="footer">
    <div class="footer-subscribe">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-large uk-flex-bottom">
                <div class="uk-width-small-1-1 uk-width-medium-1-2">
                    <div class="subscribe-content">
                        <h6 class="entry-subtitle"><span>Đăng ký để nhận ưu đãi</span></h6>
                        <h3 class="entry-title"><span>Để lại Email của bạn để nhận thông tin khuyến mãi mới nhất</span></h3>
                        <div class="entry-teaser">
                           Đăng ký email ngay bây giờ để nhận thông tin cập nhật về các chương trình khuyến mãi và phiếu thưởng.
                        </div>
                        <div class="form-wrapper">
                            <form  class="form-subscribe" method="post">
                                <div class="form-field">
                                    <i class="fa fa-envelope-o"></i>
                                    <input class="subscribe-input" type="email" name="EMAIL" placeholder="Nhập vào email của bạn" required="" />
                                    <input type="submit" value="Subscribe" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-2 ">
                    <div class="thumb">
                        <a href="" title="" class="image img-cover"><img src="public/frontend/resources/img/discount.png" alt="subscribe" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widgets ">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium ">
                <div class="uk-width-small-1-1 uk-width-medium-1-2">
                    <div class="widgets-item">
                        <h4 class="widget-title">LIÊN HỆ</h4>
                        <div class="menu-fruits-and-vegetables-container">
                            <ul class="uk-list uk-clearfix">
                                <li >
                                    <a href="<?php echo write_url('lien-he') ?>">Địa chỉ: <?php echo $general['contact_address'] ?></a>
                                </li>
                                <li >
                                    <a href="to:<?php echo $general['contact_hotline'] ?>">Số điện thoại: <?php echo $general['contact_hotline'] ?></a>
                                </li>
                                <li >
                                    <a href="mailto:<?php echo $general['contact_email'] ?>">Email: <?php echo $general['contact_email'] ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo $general['contact_website'] ?>"><?php echo $general['contact_website'] ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $footer = get_menu(['keyword' => 'menu-footer', 'language' => 2, 'output' => 'array']);  ?>
                <?php if(isset($footer['data']) && is_array($footer['data']) && count($footer['data'])){ ?>
                  <?php foreach($footer['data'] as $key => $val){ ?>
                <div class="uk-width-small-1-1 uk-width-medium-1-4">
                    <div class="widgets-item">
                        <h4 class="widget-title"><?php echo $val['title'] ?></h4>
                        <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                        <div class="menu-breakfast-dairy-container">
                            <ul id="menu-breakfast-dairy" class="uk-list uk-clearfix">
                               <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                                <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-1807">
                                    <a href="<?php echo write_url($valChild['canonical']) ?>" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a>
                                </li>
                                 <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                </div>
               <?php }} ?>
            </div>
        </div>
    </div>
    <div class="footer-contacts">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-large ">
                <div class="uk-width-small-1-1 uk-width-medium-1-3">
                    <div class="column column-left">
                        <div class="site-phone uk-flex uk-flex-middle">
                            <div class="phone-icon"><i class="klbth-icon-phone-call"></i></div>
                            <div class="phone-detail">
                                <h4 class="entry-title"><?php echo $general['contact_hotline'] ?></h4>
                                <span>Working 8:00 - 22:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" uk-width-small-1-1 uk-width-medium-2-3 uk-text-right">
                    <div class="column column-right ">
                        <div class="site-mobile-app uk-flex">
                            <div class="app-content">
                                <h6 class="entry-title">Download App on Mobile :</h6>
                                <span>15% discount on your first purchase</span>
                            </div>
                            <div class="app-buttons uk-flex">
                                <a class="image img-scaledown" href="" class="google-play">
                                    <img src="public/frontend/resources/img/google-play.png" alt="app" />
                                </a>
                                <a class="image img-scaledown" href="" class="google-play">
                                    <img src="public/frontend/resources/img/app-store.png" alt="app" />
                                </a>
                            </div>
                        </div>

                        <div class="site-social">
                            <ul class="uk-list uk-clearfix uk-flex">
                                <li>
                                    <a href="<?php echo $general['social_facebook'] ?>" target="_blank"><i class="klbth-icon-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="<?php echo $general['social_twitter'] ?>" target="_blank"><i class="klbth-icon-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="<?php echo $general['social_instagram'] ?>" target="_blank"><i class="klbth-icon-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="uk-container uk-container-center border-top">
            <div class="site-copyright">
                <div>
                   Copyright <?php echo date('Y') ?> © <?php echo $general['homepage_company'] ?>. All rights reserved. Powered by HTVIETNAM.
                </div>
                <div class="site-payments">
                   <a class="image img-scaledown" href=""><img src="public/frontend/resources/img/payments.jpg" alt="payment" /></a>
               </div>
            </div>

            <nav class="site-menu footer-menu">
                <ul class="uk-list uk-clearfix uk-flex ">
                    <li ><a href="https://klbtheme.com/bacola/privacy-policy/">Privacy Policy</a></li>
                    <li><a href="https://klbtheme.com/bacola/terms-and-conditions/">Terms and Conditions</a></li>
                    <li><a href="#">Cookie</a></li>
                </ul>
            </nav>

        </div>
    </div>

</footer>
<a href="#" class="scrollToTop button-show" aria-label="Scroll to top button"></a>
