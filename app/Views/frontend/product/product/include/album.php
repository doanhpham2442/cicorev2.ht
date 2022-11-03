 <?php $album = json_decode($product['album'], TRUE); ?>
<?php if(isset($album) && is_array($album) && count($album)){ ?>
 <div class="container-gallery">
    <div class="swiper mySwiper2">
         <div class="swiper-wrapper">
            <?php foreach($album as $key => $val){ ?>
            <div class="swiper-slide">
                 <a class="img-cover img-zoomin" href="<?php echo $val; ?>" data-uk-lightbox="{group:'group-feedback'}" title="<?php echo $product['title'] ?>">
                     <img src="<?php echo $val; ?>" alt="<?php echo $product['title'] ?>" />
                 </a>
            </div>
            <?php } ?>
         </div>
         <div class="swiper-button-next uk-text-center">
            <i class="fa fa-angle-right"></i>
         </div>
         <div class="swiper-button-prev uk-text-center">
            <i class="fa fa-angle-left"></i>
         </div>
    </div>
    <div thumbsSlider="" class="swiper mySwiper">
         <div class="swiper-wrapper">
            <?php foreach($album as $key => $val){ ?>
            <div class="swiper-slide">
                 <div href="" class="img-cover img-zoomin">
                     <img src="<?php echo $val; ?>" alt="<?php echo $product['title'] ?>" />
                 </div>
            </div>
            <?php } ?>
         </div>
         <div class="swiper-button-next uk-text-center">
            <i class="fa fa-angle-right"></i>
         </div>
         <div class="swiper-button-prev uk-text-center">
            <i class="fa fa-angle-left"></i>
         </div>
    </div>
 </div>
<?php } ?>
