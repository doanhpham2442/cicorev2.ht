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
          $('.niceSelect').niceSelect()
      }
   }


   HT.destroyNiceSelect = () => {
      if($('.niceSelect').elExists){
          $('.niceSelect').niceSelect('destroy')
      }
   }

   HT.setupProductVariant = () => {
      if($('.turnOnVariant').elExists){
         $('.turnOnVariant').click(function(){
            let _this = $(this)
            if(_this.siblings('.next-checkbox:checked').length == 0){
               $('.variantContainer').removeClass('hidden')
            }else{
               $('.variantContainer').addClass('hidden')
            }
         });
      }
   }

   HT.addVariant = () => {
      if($('.addVariant').elExists){
         $('.addVariant').click(function(){
            let attributeCatalogueList = JSON.parse(attributeCatalogue)
            let attributeCatalogueSelected = [];
            let variantItem = HT.renderVariantItem(attributeCatalogueList, attributeCatalogueSelected)
            HT.appendVariantItem(variantItem)
            HT.checkMaxVariantGroup(attributeCatalogueList)
            HT.disableSelectChoosed()

            return false
         });
      }
   }

   HT.checkMaxVariantGroup = (attributeCatalogueList) => {
      let variantItem = $('.variantItem').length
      if(variantItem >= attributeCatalogueList.length){
         $('.addVariant').hide();
      }else{
         $('.addVariant').show();
      }
   }

   HT.appendVariantItem = (variantItem) => {
      if(variantItem.length){
         $('.variantItemContainer').append(variantItem)
         HT.destroyNiceSelect()
         HT.setupNiceSelect()
         // HT.setupSelectMultiple()

      }
   }

   HT.destroySelect2 = () => {
       $(".selectVariant").select2('destroy');
   }

   HT.renderVariantItem = (attributeCatalogue, attributeCatalogueSelected) => {
      let html = ''

      html = html + '<div class="row mb20 variantItem uk-flex uk-flex-middle">'
         html = html + '<div class="col-lg-3">'
            html = html + '<div class="attributeCatalogue">'
               html = html + '<select name="attributeCatalogue" id="" class="niceSelect chooseAttributeCatalogue mt5">'
                  html = html + '<option value="0">Chọn Thuộc Tính</option>'
                  for(let i = 0; i < attributeCatalogue.length; i++){
                     html = html + '<option value="'+attributeCatalogue[i].id+'">'+attributeCatalogue[i].title+'</option>'
                  }
               html = html + '</select>'
            html = html + '</div>'
         html = html + '</div>'
         html = html + '<div class="col-lg-8 variantItemWrapper">'
            html = html + '<input type="text" disabled class="form-control fakeVariantInput" />'
         html = html + '</div>'
         html = html + '<div class="col-lg-1">'
            html = html + '<a type="button" class="btn btn-danger removeVariantItem"><svg data-icon="TrashSolidLarge" aria-hidden="true" focusable="false" width="15" height="16" viewBox="0 0 15 16" class="bem-Svg" style="display: block;"><path fill="currentColor" d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z"></path></svg></a>'
         html = html + '</div>'
      html = html + '</div>'

      return html
   }

   HT.select2VariantHtml = (attributeCatalogueId) => {
      let html = '<select name="attribute[]"  class="form-control selectVariant variant-'+attributeCatalogueId+'" multiple="multiple" data-title="Nhập 2 ký tự để tìm kiếm.." style="width:100%;" data-catid="'+attributeCatalogueId+'" data-join="attribute_translate" data-module="attributes" data-key="attribute_id" data-select="title" id=""></select>';
      return html;
   }

   HT.chooseVariantGroup = () => {
      if($('.chooseAttributeCatalogue').elExists){
         $(document).on('change', '.chooseAttributeCatalogue', function(){
            let _this = $(this)
            let attributeCatalogueId = _this.val()
            if(attributeCatalogueId != 0){
               _this.parents('.col-lg-3').siblings('.col-lg-8').html(HT.select2VariantHtml(attributeCatalogueId))
               let object = _this.parents('.col-lg-3').siblings('.col-lg-8').find('.selectVariant')

               $('.selectVariant').each(function(key, index){

                  // console.log($(this))

            		HT.getSelect2($(this));
            	});

            }else{
               _this.parents('.col-lg-3').siblings('.col-lg-8').html('<input type="text" disabled class="form-control" />')
            }
            HT.disableSelectChoosed()
         });
      }
   }

   HT.disableSelectChoosed = () => {
      let id = []
      $('select.chooseAttributeCatalogue').each(function(){
         // console.log(123)
         let _this = $(this)
         let selectedValue = _this.find('option:selected').val();
         if(selectedValue != 0){
            id.push(selectedValue);
         }
      });


      $('select.chooseAttributeCatalogue').find("option").removeAttr("disabled");
      for(let i = 0; i < id.length; i++) {
         $('select.chooseAttributeCatalogue').find("option[value="+ id[i] + "]").prop('disabled', true);
      }
      HT.destroyNiceSelect()
      HT.setupNiceSelect()
      $('select.chooseAttributeCatalogue ').find("option:selected").removeAttr("disabled");

   }


   HT.removeVariantItem = () => {
      $(document).on('click', '.removeVariantItem', function(){
         let _this = $(this)
         _this.parents('.variantItem ').remove()
         HT.disableSelectChoosed()
      });
   }

   HT.setupSelectMultiple = () => {
      if($('.selectVariant').length){
   		$('.selectVariant').each(function(){
   			let _this = $(this);
   			let select = _this.attr('data-select')
   			let module = _this.attr('data-module')
   			let join = _this.attr('data-join')
   			let key = _this.attr('data-key')
            let catalogueid = _this.attr('data-catid')

   			setTimeout(function(){
   				if(catalogue != ''){
   					$.post('ajax/dashboard/pre_select2', {
   						value: catalogue, module: module, select: select, join: join, key: key, catalogueid: catalogueid},
   						function(data){
   							let json = JSON.parse(data);
   							if(json.items!='undefined' && json.items.length){
   								for(let i = 0; i< json.items.length; i++){
   									var option = new Option(json.items[i].text, json.items[i].id, true, true);
   									_this.append(option).trigger('change');
   								}
   							}
   						});
   				}
   			}, 10);


   			HT.getSelect2(_this);
   		});
   	}

   }

   /*
      [1] => []
   */



   HT.createProductVariant = () => {
      $(document).on('change','.selectVariant', function(){
         let variant = [];
      	variant = HT.createVariant()
      });
   }

   HT.createVariant = () => {
      let attributes = []
      let variants = []
      let attributeTitle = []

      $('.variantItem').each(function(){
         let _this = $(this)
         let attr = []
         let attrVariant = []
         let attributeCatalogueId = _this.find('.chooseAttributeCatalogue').val()
         let optionText = _this.find('.chooseAttributeCatalogue option:selected').text()
         let optionValue = $('.variant-'+attributeCatalogueId).select2('val')
         let attribute = $('.variant-'+attributeCatalogueId).select2('data')


         for(let i = 0; i < attribute.length; i++){
            let item = {}
            let itemVariant = {}
            item[optionText] = attribute[i].text
            itemVariant[attributeCatalogueId] = attribute[i].id
            attr.push(item)
            attrVariant.push(itemVariant)
         }


         attributeTitle.push(optionText)

         attributes.push(attr)
         variants.push(attrVariant)
      });


      attributes = attributes.reduce(
         (a, b) => a.flatMap( d => b.map( e => ( {...d, ...e} ) ) )
      );

      variants = variants.reduce(
         (a, b) => a.flatMap( d => b.map( e => ( {...d, ...e} ) ) )
      );

      let html = HT.renderVariantHtml(attributes, variants, attributeTitle);

      $('table.variantTable').html(html)


   }
   HT.turnOnSwitch = () =>{
     $(document).ready(function(){
       var elem = document.querySelector('.js-switch');
       var switchery = new Switchery(elem, { color: '#1AB394' });
       var elem_1 = document.querySelector('.js-switch_1');
       var switchery = new Switchery(elem_1, { color: '#1AB394' });
     })
   }
   HT.changeSwitch = () =>{
      $(document).on('change', '.js-switch', function() {
        let _this = $(this)
        if(_this.prop('checked')){
          $('#quantity').removeAttr("disabled");
        }
        else{
          $('#quantity').attr("disabled", 'disabled');
        }
     });
      $(document).on('change', '.js-switch_1', function() {
        let _this = $(this)
        if(_this.prop('checked')){
          $('#file-name').removeAttr("disabled");
          $('#url').removeAttr("disabled");
        }
        else{
          $('#file-name').attr("disabled", 'disabled');
          $('#url').attr("disabled", 'disabled');
        }
     });
   }
   HT.clickVariantTr = () => {
     $(document).on('click','.variantTable tbody .tr-item', function(){
       let _this = $(this);
       $('.variantTable tbody tr').removeClass("tr-item")
       $('.variantTable tbody tr').addClass("cursor-not")
       _this.addClass("tr-select")
       let html = HT.renderOpenVariantHtml();
       _this.after(html)
       HT.turnOnSwitch();
       HT.changeSwitch();
       HT.clickCancelDropdown();



     });
   }
   HT.clickSaveDropdown = () => {
     $(document).on('click','#save-dropdown', function(){
        let quantity = $('#quantity').val()
        let sku = $('#sku').val()
        let price = $('#price-dropdown').val()
        let barcode = $('#barcode-dropdown').val()

        $('.tr-select').find('.td-quantity').html(quantity)
        $('.tr-select').find('.td-price').html(price)
        $('.tr-select').find('.td-sku').html(sku)
        $('.variantTable tbody tr').removeClass("tr-select")
        $('.variantTable tbody tr').removeClass("cursor-not")
       $('.open-form').remove();
       $('.variantTable tbody tr').addClass("tr-item")
     });
   }
   HT.clickCancelDropdown = () => {
     $(document).on('click','#cancel-dropdown', function(){

       $('.open-form').remove();
       $('.variantTable tbody tr').removeClass("tr-select")
       $('.variantTable tbody tr').removeClass("cursor-not")
       $('.variantTable tbody tr').addClass("tr-item")
     });
   }


   HT.renderVariantHtml = (attributes, variants, attributeTitle) => {
      let html = ''



      html = html + '<thead>'
         html = html + '<tr>'
            html = html + '<td>Hình Ảnh</td>'
            for(let i = 0; i < attributeTitle.length; i++){
               html = html + '<td>'+attributeTitle[i]+'</td>'
            }
            html = html + '<td class="text-right">Số lượng</td>'
            html = html + '<td class="text-right">Giá Tiền</td>'
            html = html + '<td class="text-right">SKU</td>'
         html = html + '</tr>'
      html = html + '</thead>'
      html = html + '<tbody>'
      for (var i = 0; i < attributes.length; i++) {
         html = html + '<tr class="tr-item">'
            html = html + '<td>'
               html = html + '<span class="image img-cover"><img src="https://daks2k3a4ib2z.cloudfront.net/6343da4ea0e69336d8375527/6343da5f04a965c89988b149_1665391198377-image16-p-500.jpg" alt=""></span>'
            html = html + '</td>'
            $.each(attributes[i], function (index, value) {
                 html = html + '<td>'+value+'</td>'
            });
            html = html + '<td class="text-right td-quantity">∞</td>'
            html = html + '<td class="text-right td-price"><span class="int">1.000.000</span></td>'
            html = html + '<td class="text-right td-sku">123324327</td>'
         html = html + '</tr>'

      }
      html = html + '</tbody>'

      return html
   }

   HT.renderOpenVariantHtml = () => {
     let html = ''

     html = html + '<tr class="open-form">'
      html = html + '<td colspan="7" >'
        html = html + '<div class="ibox mb20 album">'
          html = html + '<div class="ibox-title" style="padding: 9px 15px 0px;">'
            html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
               html = html + '<h5>Thêm mới phiên bản sản phẩm </h5>'
               html = html + '<div class="ibox-tools uk-flex uk-flex-middle">'
                  html = html + '<button type="button" id ="cancel-dropdown" name="cancel-dropdown" value="cancel-dropdown" class="btn btn-warning block full-width m-b mr10">Hủy bỏ</button>'
                  html = html + '<button type="button" id ="save-dropdown" name="save-dropdown" value="save-dropdown" class="btn btn-primary block full-width m-b">Lưu lại</button>'
               html = html + '</div>'
            html = html + '</div>'
         html = html + '</div>'
         html = html + '<div class="ibox-content">'
             html = html + '<div class="row">'
                html = html + '<div class="col-lg-12 mb10">'
                  html = html + '<label class="control-label text-left">'
                      html = html + '<span>Thêm album phiên bản</span>'
                  html = html + '</label>'
                   html = html + '<div class="click-to-upload">'
                      html = html + '<div class="icon">'
                         html = html + '<a type="button" class="upload-picture" onclick="BrowseServerAlbum($(this));return false;">'
                            html = html + '<svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>'
                         html = html + '</a>'
                      html = html + '</div>'
                      html = html + '<div class="small-text">Sử dụng nút chọn hình để thêm mới hình ảnh</div>'
                   html = html + '</div>'
                   html = html + '<div class="upload-list" style="display:none">'
                      html = html + '<div class="row">'
                         html = html + '<ul id="sortable" class="clearfix data-album sortui ui-sortable"></ul>'
                      html = html + '</div>'
                   html = html + '</div>'
                html = html + '</div>'
                html = html + '<div class="col-lg-2 mb10">'
                  html = html + '<label class="control-label text-left">'
                      html = html + '<span>Quản lý tồn kho</span>'
                  html = html + '</label>'
                  html = html + '<input type="checkbox" class="js-switch" />'
                html = html + '</div>'
                html = html + '<div class="col-lg-10 mb10">'
                  html = html + '<div class="row">'
                    html = html + '<div class="col-lg-3">'
                      html = html + '<div class="form-row">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>Số lượng</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" disabled id = "quantity" name="quantity" value="∞" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                    html = html + '<div class="col-lg-3">'
                      html = html + '<div class="form-row">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>SKU</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" id = "sku"  name="sku" value="0" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                    html = html + '<div class="col-lg-3">'
                      html = html + '<div class="form-row">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>Giá bán</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" id = "price-dropdown" name="price" value="0" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                    html = html + '<div class="col-lg-3">'
                      html = html + '<div class="form-row">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>Barcode</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" id = "barcode-dropdown" name="barcode" value="0" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                html = html + '</div>'
               html = html + '</div>'
                html = html + '<div class="col-lg-2">'
                  html = html + '<div class="switch">'
                    html = html + '<label class="control-label text-left">'
                        html = html + '<span>Download File</span>'
                    html = html + '</label>'
                    html = html + '<input type="checkbox" class="js-switch_1"/>'
                  html = html + '</div>'
                html = html + '</div>'
                html = html + '<div class="col-lg-10">'
                  html = html + '<div class="row">'
                    html = html + '<div class="col-lg-6">'
                      html = html + '<div class="form-row mb10">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>Tên file</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" disabled id = "file-name" name="file-name" value="" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                    html = html + '<div class="col-lg-6">'
                      html = html + '<div class="form-row mb10">'
                         html = html + '<label class="control-label text-left">'
                             html = html + '<span>Đường dẫn</span>'
                         html = html + '</label>'
                         html = html + '<input type="text" disabled id = "url" name="url" value="" class="form-control" placeholder="" autocomplete="off">'
                      html = html + '</div>'
                   html = html + '</div>'
                  html = html + '</div>'
               html = html + '</div>'
             html = html + '</div>'
          html = html + '</div>'
        html = html + '</div>'
       html = html + '</td>'
     html = html + '</tr>'

       return html
   }



   HT.getSelect2 = (object) => {
      let module = object.attr('data-module');
      let select = object.attr('data-select');
      let join = object.attr('data-join');
      let key = object.attr('data-key');
      let catalogueid = object.attr('data-catid');

      clearTimeout(timer)
      timer = setTimeout(function(){
         $(object).select2({
            minimumInputLength: 2,
            placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
               ajax: {
                  url: 'ajax/product/get_select2',
                  type: 'POST',
                  dataType: 'json',
                  deley: 250,
                  data: function (params) {
                     return {
                        locationVal: params.term,
                        module:module,
                        select: select,
                        join: join,
                        key: key,
                        catalogueid: catalogueid,

                     };
                  },
                  processResults: function (data) {
                     return {
                        results: $.map(data, function(obj, i){
                           return obj
                        })
                     }
                  },
                  cache: true,
               }
         });
      }, 200)

   }


   // Document ready functions
   $document.ready(function() {

      HT.setupNiceSelect ();
      HT.setupSelectMultiple();
      HT.setupProductVariant();
      HT.addVariant();
      HT.chooseVariantGroup();
      HT.removeVariantItem();
      HT.createProductVariant();
      HT.clickVariantTr();
      HT.turnOnSwitch();
      HT.changeSwitch();
      HT.clickSaveDropdown();

   });


})(jQuery);
