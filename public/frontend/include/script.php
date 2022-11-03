<script src="resources/function.js"></script>
<script src="resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>   
<script src="resources/uikit/js/uikit.min.js"></script>
<script src="resources/uikit/js/uikit-slideshow.js"></script>
<script src="resources/library/js/jquery.js"></script>
<script src="resources/uikit/js/components/lightbox.min.js"></script>
<script type='text/javascript' src='resources/plugins/bacola/comment-reply.min.js'></script>
<script type='text/javascript' src='resources/plugins/bacola/imagesloaded.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/bootstrap.bundle.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/select2.full.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/slick.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/gsap.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/jquery.magnific-popup.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/perfect-scrollbar.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/bundle.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/core.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/mouse.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/sortable.min.js' ></script>
<script type='text/javascript' src='resources/plugins/bacola/slider.min.js'></script>
<script type='text/javascript' src='resources/plugins/bacola/accounting.min.js' ></script>
<script type='text/javascript' id='wc-price-slider-js-extra'>
    var woocommerce_price_slider_params = {"currency_format_num_decimals":"0","currency_format_symbol":"$","currency_format_decimal_sep":".","currency_format_thousand_sep":",","currency_format":"%s%v"};
</script>
<script type='text/javascript' src='resources/plugins/bacola/price-slider.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.header-location').on('click', function(){
            var select_location = $('.select-location');
            select_location.addClass('active');
            return false;
        });
        $('.close-popup').on('click', function(){
            var select_location = $('.select-location');
            select_location.removeClass('active');
            return false;
        });
    });
    $(document).click(function (e)
{
    var select_location_wrapper = $(".select-location-wrapper");
    var select_location = $(".select-location");
    if (!select_location_wrapper.is(e.target) && select_location_wrapper.has(e.target).length === 0)
    {
        select_location.removeClass('active');
    }
    $(document).ready(function(){
        $('.regiser-choose').on('click', function(){
            var login_form_container = $('.login-form-container');
            var login_choose = $('.login-choose');
            var regiser_choose = $('.regiser-choose');
            login_form_container.addClass('show-register-form');
            login_choose.removeClass('active');
            regiser_choose.addClass('active');
            return false;
        });
        $('.login-choose').on('click', function(){
            var login_form_container = $('.login-form-container');
            var login_choose = $('.login-choose');
            var regiser_choose = $('.regiser-choose');
            login_form_container.removeClass('show-register-form');
            regiser_choose.removeClass('active');
            login_choose.addClass('active');
            return false;
        });
    });
});
</script>
<script type="text/javascript">
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 3,
        freeMode: true,
        watchSlidesProgress: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>