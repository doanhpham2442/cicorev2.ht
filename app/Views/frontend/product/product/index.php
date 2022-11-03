<div class="product-detailpage">
   <div class="product-detail-content">
        <div id="div" class="site-primary">
            <div class="shop-content single-content single-gray single-type3">
                <div class="container">
                    <?php echo view(route('frontend.product.product.include.breadcrumb')) ?>

                    <div class="single-wrapper">
                        <div  class="product">
                            <div class="product-content">
                                <div class="product-header">
                                    <h1 class="product_title entry-title"><?php echo $product['title'] ?></h1>
                                    <div class="product-meta top">
                                        <div class="product-brand">
                                            <span >Danh mục:</span>
                                            <span class="bold"><?php echo $productCatalogue['title'] ?></span>
                                        </div>

                                        <div class="woocommerce-product-rating product-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width: 100%;">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                            </div>
                                            <div class="count-rating">
                                                <a href="#reviews" class="woocommerce-review-link" rel="nofollow"><span class="count">1</span> review</a>
                                            </div>
                                        </div>

                                        <div class="sku-wrapper">
                                            <span>SKU:</span>
                                            <span class="sku"><?php echo $product['code'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-grid uk-grid-large">
                                    <div class="uk-width-small-1-1 uk-width-medium-2-5">
                                       <?php echo view(route('frontend.product.product.include.album')) ?>
                                    </div>

                                    <div class="uk-width-small-1-1 uk-width-medium-3-5 product-detail">

                                       <?php echo view(route('frontend.product.product.include.information')) ?>
                                       <div class="column product-icons">
                                            <div class="icon-messages">
                                                <ul>
                                                    <li>
                                                        <div class="icon"><i class="klbth-icon-delivery-truck-2"></i></div>
                                                        <div class="message">Miễn phí vận chuyển với đơn hàng nội thành</div>
                                                    </li>
                                                    <li>
                                                        <div class="icon"><i class="klbth-icon-milk-box"></i></div>
                                                        <div class="message">Sản xuất từ nguyên liệu an toàn sức khỏe 100%</div>
                                                    </li>
                                                    <li>
                                                        <div class="icon"><i class="klbth-icon-dollar"></i></div>
                                                        <div class="message">Đổi trả trong ngày</div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo view(route('frontend.product.product.include.general')) ?>
                        <?php echo view(route('frontend.product.product.include.related')) ?>
                        <div class="single-sticky-titles"><div class="container"></div></div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
