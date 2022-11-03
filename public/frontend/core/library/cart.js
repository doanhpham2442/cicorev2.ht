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

   HT.addCart = () => {
      if($('.addCart').elExists){
         $(document).on('click', '.addCart', function(){
            let _this = $(this)
            let productId = _this.attr('data-id')
            let quantity = $('.quantity').val()

            if(quantity == 0 || typeof(quantity) == 'undefined'){
               quantity = 1
            }

            let checkProductVariant = HT.processProductVariant();
            if(checkProductVariant.error != 200){
               toastr.error(checkProductVariant.message, 'Có lỗi xảy ra!')
               return false
            }

            $.ajax({
               type        : 'POST',
               url         :  'ajax/cart/addCart',
               data		: {
                  productId: productId,
                  quantity: quantity,
               },
               dataType    : 'json',
               success: function(data){
                  if(data.code == 200){
                     toastr.success(data.message, 'Thông báo từ hệ thống!')
                     HT.changeMiniCart(data);

                  }else{
                     toastr.error('Thêm sản phẩm vào giỏ hàng không thành công', 'Có lỗi xảy ra!')
                  }

               }
            })

            return false;
         });
      }
   }

   HT.removeCartItem = () => {
      if($('.removeCartItem').elExists){
         $(document).on('click', '.removeCartItem', function(){
            let _this = $(this);
            let rowid = _this.attr('data-rowid')

            $.ajax({
               type        : 'POST',
               url         :  'ajax/cart/removeCartItem',
               data		: {
                  rowid: rowid,
               },
               dataType    : 'json',
               success: function(data){

                  if(data.code == 200){
                     toastr.success(data.message, 'Thông báo từ hệ thống!')
                     HT.changeMiniCart(data)
                     HT.removeMiniCartRow(rowid)

                  }else{
                     toastr.error('Xóa sản phẩm không thành công, hãy thử lại', 'Có lỗi xảy ra!')
                  }

               }
            })

            return false;
         });
      }
   }

   HT.changeQuantity = () => {

      if($('.is-form').elExists){
         $(document).on('click', '.is-form', function(){
            let _this = $(this)
            let inputType = ( _this.hasClass('minus') ) ? 'minus' : 'plus'
            let quantity = _this.siblings('.input-qty').val()
            let rowid = _this.siblings('.input-qty').attr('data-rowid')
            let price = _this.siblings('.input-qty').attr('data-price')


            let quantityOutput = ( inputType == 'minus' )  ? parseInt(quantity) - 1 : parseInt(quantity) + 1
            if(quantityOutput <= 0){
               quantityOutput = 1
            }
            let subTotal = price*quantityOutput
            _this.siblings('.input-qty').val(quantityOutput)
            HT.updateCart(rowid, quantityOutput, subTotal, _this)

         });
      }


   }

   HT.applyVoucherToCart = () => {
      $('.applyVoucher').on('click', function(){
         let _this = $(this)
         let voucher = $('input[name=voucher]').val()
         $.ajax({
            type        : 'POST',
            url         :  'ajax/cart/applyVoucher',
            data		: {
               voucher: voucher,
            },
            dataType    : 'json',
            success: function(data){
               if(data.code == 200){
                  toastr.success(data.message, 'Thông báo từ hệ thống!')
                  setTimeout(function(){
                     location.reload();
                  }, 1000);
               }else{
                  toastr.error(data.message, 'Có lỗi xảy ra!')
               }
            }
         })
         return false;
      });
   }

   HT.addVoucher = () => {
      if($('.voucher-item').elExists) {
         $(document).on('click', '.voucher-item', function(){
            let _this = $(this)
            let voucher = _this.attr('data-voucher')
            HT.changeDiscountBox(voucher)
         });
      }
   }

   HT.changeDiscountBox = (voucher) => {
      if($('.discount-box').elExists) {
         $('.discount-box input[name=voucher]').val(voucher)
         HT.checkDiscountBoxButton($('.discount-box input[name=voucher]'))
      }
   }

   HT.onKeyUpDiscountBox = () => {
      $(document).on('keyup', '.discount-box input[name=voucher]', function(){
         let _this = $(this)
         HT.checkDiscountBoxButton(_this)
      });
   }

   HT.checkDiscountBoxButton = (object) => {
      if(object.val() != '' && object.val() != 'undefined'  ){
         $('.applyVoucher').prop('disabled', false)
      }else{
         console.log(43)
         $('.applyVoucher').prop('disabled', true)
      }
   }


   HT.updateCart = (rowid, quantity, subTotal, _this) => {

      clearTimeout(timer)
      timer = setTimeout(function(){
         $.ajax({
            type        : 'POST',
            url         :  'ajax/cart/updateCart',
            data		: {
               rowid: rowid,
               quantity: quantity,
            },
            dataType    : 'json',
            success: function(data){
               if(data.code == 200){
                  toastr.success(data.message, 'Thông báo từ hệ thống!')
                  HT.changeMiniCart(data);
                  _this.parents('.buttons_added').siblings('.price-cart').find('.new-pricce').html(HT.addCommas(subTotal) + ' đ')

               }else{
                  toastr.error('Cập nhật không thành công, hãy thử lại', 'Có lỗi xảy ra!')
               }

            }
         })
      }, 500)

   }

   HT.changeMiniCart = (data) => {
      $('.cartItem').html(data.totalItems)
      $('.cartTotal').html(data.total)
      $('.cart-empty').html(data.html)
   }

   HT.removeMiniCartRow = (rowid) => {
      $('.'+rowid).remove()
   }

   HT.processProductVariant = () => {
      let message = 'Bạn chưa chọn thuộc tính cho sản phẩm';
      let error = 200;

      return {
         'message' : message,
         'error' : error,
      }
   }

   HT.addCommas = (nStr) => {
      nStr = String(nStr);
      nStr = nStr.replace(/\./gi, "");
      let str ='';
      for (let i = nStr.length; i > 0; i -= 3){
         let a = ( (i-3) < 0 ) ? 0 : (i-3);
         str= nStr.slice(a,i) + '.' + str;
      }
      str= str.slice(0,str.length-1);
      return str;
   }

   // Document ready functions
   $document.ready(function() {
      HT.addCart();
      HT.removeCartItem();
      HT.changeQuantity();
      HT.addVoucher();
      HT.onKeyUpDiscountBox();
      HT.applyVoucherToCart();
   });

})(jQuery);
