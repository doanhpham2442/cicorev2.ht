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


   HT.setupNiceSelect = () => {
      if($('.niceSelect').elExists){
          $('.niceSelect').niceSelect();
      }
   }

   HT.search = () => {
      if($('.ajaxSearch').elExists){
         $('.ajaxSearch').on('keyup', function(){

            let _this = $(this)
            let keyword = _this.val()

            if(keyword.length > 2){
               clearTimeout(timer)
               timer = setTimeout(function(){
                  $.ajax({
                     type        : 'POST',
                     url         :  'ajax/search/index',
                     data		: {
                        keyword: keyword,
                     },
                     dataType    : 'json',
                     success: function(data){
                        if(data.length > 0){
                           $('.ajaxSearchResult').show();
                           $('.ajaxSearchResult').html(data)
                        }else{
                           $('.ajaxSearchResult').hide();
                           $('.ajaxSearchResult').html('');
                        }
                     }
                  })
               }, 200)
            }

         });
      }
   }

   // Document ready functions
   $document.ready(function() {

      HT.setupNiceSelect();
      HT.search();

   });


})(jQuery);


$(document).ready(function(){
   $(document).on('change', '#city', function(e, data){
      let _this = $(this);
      let id = _this.val();
      let param = {
         'id' : id,
         'text' : '[Chọn Quận/Huyện]',
         'table' : 'vn_district',
         'trigger_district': (typeof(data) != 'undefined') ? true : false,
         'where' : {'provinceid' : id},
         'select' : 'districtid as id, name',
         'object' : '#district',
      };
      getLocation(param);
   });

   if(typeof(cityid) != 'undefined' && cityid != ''){
      $('#city').val(cityid).trigger('change', [{'trigger':true}]);
      // HT.changeCity(123);
   }

   $(document).on('change', '#district', function(){
      let _this = $(this);
      let id = _this.val();
      let param = {
         'id' : id,
         'text' : '[Chọn Phường/Xã]',
         'table' : 'vn_ward',
         'where' : {'districtid' : id},
         'select' : 'wardid as id, name',
         'object' : '#ward',
      };
      getLocation(param);
   });


});

function getLocation(param){
   if(districtid == '' || param.trigger_district == false) districtid = 0;
   if(wardid == ''  || param.trigger_ward == false) wardid = 0;

   let formURL = 'ajax/dashboard/get_location';
   $.post(formURL, {
      param: param},
      function(data){
         let json = JSON.parse(data);

         console.log(json.html)

         if(param.object == '#district'){
            $(param.object).html(json.html).val(districtid);
             $('#district').niceSelect('destroy');
             $('#district').niceSelect();
         }else if(param.object == '#ward'){
            $(param.object).html(json.html).val(wardid);
            $('#ward').niceSelect('destroy');
            $('#ward').niceSelect();
         }
      });
}
