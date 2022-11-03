(function($) {
   "use strict";
   var HT = {}; // Khai báo là 1 đối tượng
   var timer = null

/* MAIN VARIABLE */

   var   $window = $(window),
         $document = $(document);


   // FUNCTION DECLARGE
   $.fn.elExists = function() {
     return this.length > 0;
   };

   HT.chooseStarRating = () => {
      if($('.choose-start').elExists){
         $(document).on('click', '.choose-start', function(){
            let _this = $(this);
            $('.choose-start').removeClass('active')
            _this.addClass('active')

            $('input[name=rate]').val(_this.attr('data-value'))

            return false;
         });
      }
   }

   HT.sendReview = () => {
      if($('#reviewForm').elExists){
         $(document).on('submit','#reviewForm', function(){
            let _this = $(this);
            let post = _this.serializeArray();
            let rate = $('input[name=rate]').val();
            let product_id = $('input[name=product_id]').val()
            if(rate == '' || rate == 0){
               toastr.error('Bạn chưa chọn điểm đánh giá.', 'Có lỗi xảy ra!')
               return false;
            }
            $.ajax({
               type        : 'POST',
               url         :  'ajax/review/send',
               data		: {
                  post: post,
                  rate: rate,
                  product_id : product_id
               },
               dataType    : 'json',
               success: function(data){
                  if(data == 200){
                     toastr.success('Gửi đánh giá thành công, Nội dung sẽ được kiểm duyệt trước khi hiển thị.', 'Thông báo từ hệ thống!')

                  }else{
                     toastr.error('Gửi đánh giá không thành công, Hãy Thử lại.', 'Có lỗi xảy ra!')
                  }

               }
            })

            setTimeout(function(){
               location.reload();
            }, 1000);

            return false;
         });
      }
   }

   // Document ready functions
   $document.ready(function() {

      HT.chooseStarRating();
      HT.sendReview();

   });


})(jQuery);
