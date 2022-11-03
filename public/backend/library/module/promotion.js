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

   HT.changePromotion = () => {
      if($('.discount-button_type').elExists){
         $('.discount-button_type').click(function(){
            let _this = $(this);
            let radio = _this.find('input[type=radio]')
            radio.prop('checked', true);
            $('.discount-button_type').removeClass('active');
            _this.addClass('active');
            if(radio.val() == 'money'){
               $('.discount-container').html(HT.discountMoney())
            }else{
               $('.discount-container').html(HT.discountSamePrice())
            }
            HT.initializeSelect2();
         });
      }
   }

   HT.discountMoney = () => {
      let html = '';
      html = html + '<div class="col-lg-12 mt20">'
         html = html + '<div class="form-row">'
            html = html + '<label class="control-label text-left">'
               html = html + '<span>Mức giảm'
               html = html + '</span>'
            html = html + '</label>'
         html = html + '</div>'
      html = html + '</div>'
      html = html + '<div class="col-lg-6 discount_block">'
        html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
          html = html + '<div class="uk-flex uk-flex-middle">'
            html = html + '<input type="text" name="discount_value" value="0" class="form-control discount-value int" placeholder="Nhập trị số giảm" autocomplete="off">'
            html = html + '<select name="discount_type" class="nice-select ml10">'
               html = html + '<option value="money">đ</option>'
               html = html + '<option value="percent">%</option>'
            html = html + '</select>'
          html = html + '</div>'
        html = html + '</div>'
      html = html + '</div>'

      return html;
   }

   HT.discountSamePrice = () => {
      let html = ''
      html = html + '<div class="col-lg-12 mt20">'
         html = html + '<div class="form-row">'
            html = html + '<label class="control-label text-left">'
               html = html + '<span>Đồng giá</b>'
               html = html + '</span>'
            html = html + '</label>'
         html = html + '</div>'
      html = html + '</div>'
      html = html + '<div class="col-lg-6 discount_block">'
        html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
          html = html + '<div class="uk-flex uk-flex-middle">'
            html = html + '<input type="text" name="discount_value" value="0" class="form-control discount-value int" placeholder="Nhập trị số giảm" autocomplete="off">'
          html = html + '</div>'
        html = html + '</div>'
      html = html + '</div>'

      return html;
   }


   HT.initializeSelect2 = () => {
      if($('.nice-select').elExists){
         $('.nice-select').niceSelect();
      }
   }

   HT.initializeFindObject = () => {
      $('.hrv-next-input-radio').click(function(){
         let _this = $(this)
         let input = _this.find('input[type=radio]').val();
         $('.next-input--invisible').attr('data-module', input)
         $('.selected-module').val(input)
         $('.choose-collection').html('')
      });
   }

   HT.findObject = () => {
      let inputSearch = $('.next-input')
      if(inputSearch.elExists()){
         inputSearch.on('keyup', function(){
            let _this = $(this)
            let keyword = _this.val()
            let module = _this.attr('data-module')
            let start = _this.attr('data-start')

            clearTimeout(timer)
            timer = setTimeout(function(){

               if(keyword.length > 2){
                  $.ajax({
                     type        : 'POST',
                     url         :  'ajax/promotion/search',
                     data		: {
                        module: module,
                        keyword: keyword,
                        start: start
                     },
                     dataType    : 'json',
                     success: function(data){
                        $('.ui-popover-control').removeClass('hidden')
                        $('.ui-popover-control').html(HT.renderSearchResult(data))
                     }
                  })
               }

            }, 500)
         });
      }
   }

   HT.renderSearchResult = (data) => {
      let html = ''


      html = html + '<div class="ui-popover-dropdown">'
         html = html + '<div class="ui-popover-body">'
            html = html + '<div class="object-list">'
            for(let i = 0; i < data.length; i++){

               let flag = ( $('#product-'+data[i].id).length ) ? '1' : '0'

               html = html + '<button class="discount-combobox-item" data-flag="'+flag+'" data-canonical="'+data[i].canonical+'" data-image="'+data[i].image+'" data-title="'+data[i].title+'" data-id="'+data[i].id+'">'
                  html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
                     html = html + '<span>'+data[i].title+'</span>'
                     html = html + '<div class="my-auto">'+((flag == 1) ? '<svg class="svg-next-icon button-selected-combobox svg-next-icon-size-12" width="12" height="12"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"><path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path></svg></svg>' : '')+'</div>'
                  html = html + '</div>'
               html = html + '</button>'
            }
            html = html + '</div>'
         html = html + '</div>'
         html = html + '<div class="ui-popover-footer hidden">'
            html = html + '<div class="text-right">'
               html = html + '<button class="btn btn-default previous" data-start=""  ><i class="fa fa-angle-left" aria-hidden="true"></i></button>'
               html = html + '<button class="btn btn-default next" data-start="" ><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
            html = html + '</div>'
         html = html + '</div>'
      html = html + '</div>'

      return html;
   }

   HT.setChecked = () => {
      let html = '<svg class="svg-next-icon button-selected-combobox svg-next-icon-size-12" width="12" height="12"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"><path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path></svg></svg>';

      return html;
   }

   HT.chooseObject = () => {

      $(document).on('click', '.discount-combobox-item', function(){
         let _this = $(this);
         let flag = _this.attr('data-flag');
         let data = {
            'title' : _this.attr('data-title'),
            'canonical' : _this.attr('data-canonical'),
            'id' : _this.attr('data-id'),
            'image' : _this.attr('data-image'),
         }


         if(flag == 0){
            _this.find('.my-auto').html(HT.setChecked())
            _this.attr('data-flag', 1)
            $('.choose-collection').append(HT.initializeObjectToList(data))
         }else{
            $('#product-'+data.id).remove();

            _this.find('.my-auto').html('')
            _this.attr('data-flag', 0)
         }

         return false;

      });
   }

   HT.deleteObjectFromChooseList = () => {
      $(document).on('click', '.deleted', function(){
         let _this = $(this);
         _this.parents('.selected-item').remove();
      });
   }

   HT.initializeObjectToList = (data) => {
      let html = ''

      html = html + '<div class="selected-item" id="product-'+data.id+'">'
         html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
            html = html + '<div class="uk-flex uk-flex-middle">'
               html = html + '<div class="s-image img-scaledown"><img src="'+data.image+'" alt=""></div>'
               html = html + '<div class="s-name"><a href="'+data.canonical+'.html" title="">'+data.title+'</a></div>'
               html = html + '<input type="hidden" name="object_id[]" value="'+data.id+'" />'
            html = html + '</div>'
            html = html + '<div class="deleted">'
               html = html + '<svg class="svg-next-icon svg-next-icon-size-12" width="12" height="12"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18.263 16l10.07-10.07c.625-.625.625-1.636 0-2.26s-1.638-.627-2.263 0L16 13.737 5.933 3.667c-.626-.624-1.637-.624-2.262 0s-.624 1.64 0 2.264L13.74 16 3.67 26.07c-.626.625-.626 1.636 0 2.26.312.313.722.47 1.13.47s.82-.157 1.132-.47l10.07-10.068 10.068 10.07c.312.31.722.468 1.13.468s.82-.157 1.132-.47c.626-.625.626-1.636 0-2.26L18.262 16z"></path></svg></svg>'
            html = html + '</div>'
         html = html + '</div>'
      html = html + '</div>'

      return html
   }

   HT.unFocusSearchBox = () => {
      $(document).on('click', 'html', function(e){

         if($(e.target).hasClass('next-input') || !$(e.target).hasClass('ui-popover-control') )
         {
            // console.log(e.target);

            $('.ui-popover-control').html('');
         }
      });
   }


   // Document ready functions
   $document.ready(function() {

      HT.changePromotion();
      HT.initializeFindObject();
      HT.findObject();
      HT.chooseObject();
      HT.unFocusSearchBox();
      HT.deleteObjectFromChooseList();

   });


})(jQuery);
