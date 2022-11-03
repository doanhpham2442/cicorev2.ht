<div class="woocommerce-tabs">
    <ul class=" wc-tabs"  data-uk-switcher="{connect:'#my-id'}">
       <li class="description_tab" id="tab-title-description" role="tab" >
            <a href=""> Mô tả sản phẩm </a>
       </li>
       <li class="reviews_tab" id="tab-title-reviews" role="tab" >
            <a href=""> Đánh giá sản phẩm</a>
       </li>
    </ul>
    <ul id="my-id" class="uk-switcher">
      <li>
           <div class="woocommerce-Tabs-panel ">
               <?php echo $product['content']; ?>
           </div>
      </li>
      <li>
           <div class="woocommerce-Tabs-panel">
               <div class="woocommerce-Reviews">
                    <div id="comments">
                        <h2 class="woocommerce-Reviews-title"><?php echo $productReviewStatistic['totalReview']; ?> đánh giá cho sản phẩm <span><?php echo $product['title'] ?></span></h2>

                        <?php if(isset($productReview) && is_array($productReview) && count($productReview)){ ?>
                        <ol class="commentlist">
                           <?php foreach($productReview as $key => $val){ ?>
                           <li class="review byuser comment-author-bacola bypostauthor even thread-even depth-1" id="li-comment-64">
                                <div id="comment-64" class="comment_container">
                                    <img
                                        alt=""
                                        src="https://secure.gravatar.com/avatar/3384f98a21c5dce2051e8f5a20928b05?s=60&#038;d=mm&#038;r=g"
                                        srcset="https://secure.gravatar.com/avatar/3384f98a21c5dce2051e8f5a20928b05?s=120&#038;d=mm&#038;r=g 2x"
                                        class="avatar avatar-60 photo"
                                        height="60"
                                        width="60"
                                        loading="lazy"
                                    />
                                    <div class="comment-text">
                                        <div class="star-rating" role="img" aria-label="Rated 5 out of 5">
                                            <span style="width: 100%;">Rated <strong class="rating"><?php echo $val['rate'] ?></strong> trên 5</span>
                                        </div>
                                        <p class="meta">
                                            <strong class="woocommerce-review__author"><?php echo $val['fullname'] ?> </strong>
                                            <span class="woocommerce-review__dash">&ndash;</span> <time class="woocommerce-review__published-date" datetime="2021-05-01T10:09:09+00:00"><?php echo changeDateFormat($val['created_at'],'d-m-Y H:i') ?></time>
                                        </p>

                                        <div class="description"><p><?php echo $val['description']; ?></p></div>
                                    </div>
                                </div>
                           </li>
                           <?php } ?>
                           <!-- #comment-## -->
                        </ol>
                        <?php } ?>
                    </div>

                    <div id="review_form_wrapper">
                        <div id="review_form">
                           <div id="respond" class="comment-respond">
                                <span id="reply-title" class="comment-reply-title">
                                    Đánh giá sản phẩm
                                    <small><a rel="nofollow" id="cancel-comment-reply-link" href="/bacola/product/blue-diamond-almonds-lightly-salted/?opt=type3#respond" style="display: none;">Cancel reply</a></small>
                                </span>
                                <form action="" method="post" id="reviewForm" class="comment-form">
                                   <input type="hidden" value="<?php echo $product['id'] ?>" name="product_id" class="product_id">
                                   <input type="hidden" value="0" name="rate" class="rate">
                                    <p class="comment-notes">
                                        <span id="email-notes">Email của bạn sẽ không được công khai.</span>
                                        <span class="required-field-message" aria-hidden="true">Các trường có dấu * là bắt buộc <span class="required" aria-hidden="true">*</span></span>
                                    </p>
                                    <div class="comment-form-rating">
                                        <label for="rating">Đánh giá <span class="required">*</span></label>
                                        <p class="stars">
                                            <span>
                                               <a class="star-1 choose-start" data-value="1" href="#">1</a>
                                               <a class="star-2 choose-start" data-value="2" href="#">2</a>
                                               <a class="star-3 choose-start" data-value="3" href="#">3</a>
                                               <a class="star-4 choose-start" data-value="4" href="#">4</a>
                                               <a class="star-5 choose-start" data-value="5" href="#">5</a>
                                            </span>
                                        </p>
                                    </div>
                                    <p class="comment-form-comment">
                                        <label for="comment">Đánh giá của bạn <span class="required">*</span></label><textarea id="comment" name="description" cols="45" rows="8" required ></textarea>
                                    </p>
                                    <p class="comment-form-author">
                                        <label for="author">Họ Tên <span class="required">*</span></label><input id="author" name="fullname" type="text" value="" size="30"  required/>
                                    </p>
                                    <p class="comment-form-email">
                                        <label for="email">Email <span class="required">*</span></label><input id="email" name="email" type="email" value="" size="30"  required/>
                                    </p>
                                    <p class="form-submit">
                                        <input name="submit" type="submit" id="submit" class="submit" value="Gửi đánh giá" />
                                        <input name="reset" type="rest" id="submit" class="reset uk-hidden" value="Submit" />
                                    </p>
                                </form>
                           </div>
                           <!-- #respond -->
                        </div>
                    </div>

                    <div class="clear"></div>
               </div>
           </div>
      </li>


    </ul>
</div>
