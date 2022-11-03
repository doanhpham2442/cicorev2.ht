<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Danh mục cha</h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row mb10">
               <small class="text-danger">* Lựa chọn danh mục cha</small>
            </div>
            <div class="form-row">
               <?php echo form_dropdown('product_catalogue_id', $dropdown, set_value('product_catalogue_id', (isset($product['product_catalogue_id'])) ? $product['product_catalogue_id'] : ''), 'class="form-control m-b select2"');?>
            </div>

            <script>
               var catalogue = '<?php echo (request()->getPost('catalogue')) ? json_encode(request()->getPost('catalogue')) : ((isset($product['catalogue']) && $product['catalogue'] != null) ? $product['catalogue'] : '');  ?>';
            </script>
            <div class="form-row mt20">
                  <label class="control-label text-left">
                     <span>Danh mục phụ</span>
                  </label>

                  <div class="form-row">
                     <?php echo form_dropdown('catalogue[]', '', NULL, 'class="form-control selectMultiple" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm..."  style="width: 100%;" data-join="'.$module.'_catalogue_translate" data-module="'.$module.'_catalogues" data-key="'.$module.'_catalogue_id'.'" data-select="title"'); ?>
                  </div>
               </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20">
   <div class="ibox-title">
      <h5 class="choose-image" style="cursor: pointer;">Ảnh đại diện </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row">
               <div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($product['image']) && $product['image'] != '') ? $product['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
               <?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($product['image'])) ? $product['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20">
   <div class="ibox-title">
      <h5 class="choose-image" style="cursor: pointer;">Thông tin sản phẩm </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row mb10">
               <label class="control-label text-left">
                   <span>Giá bán</span>
               </label>
               <?php echo form_input('price', htmlspecialchars_decode(html_entity_decode(set_value('price', (isset($product['price'])) ? $product['price'] : ''))), 'class="form-control int" placeholder=""   autocomplete="off"');?>
            </div>
            <div class="form-row mb15">
               <label class="control-label text-left">
                   <span>Giá khuyến mãi</span>
               </label>
               <?php echo form_input('price_sale', htmlspecialchars_decode(html_entity_decode(set_value('price_sale', (isset($product['price_sale'])) ? $product['price_sale'] : ''))), 'class="form-control int" placeholder=""   autocomplete="off"');?>
            </div>
            <div class="form-row mb15">
               <label class="control-label text-left">
                   <span>Mã sản phẩm</span>
               </label>
               <?php echo form_input('code', htmlspecialchars_decode(html_entity_decode(set_value('code', (isset($product['code'])) ? $product['code'] : time()))), 'class="form-control" placeholder=""   autocomplete="off"');?>
            </div>
            <div class="form-row">
               <label class="control-label text-left">
                   <span>Xuất xứ</span>
               </label>
               <?php echo form_input('made_in', htmlspecialchars_decode(html_entity_decode(set_value('made_in', (isset($product['made_in'])) ? $product['made_in'] : ''))), 'class="form-control" placeholder=""   autocomplete="off"');?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Hiển thị</h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row">
               <div class="text-warning mb15">Quản lý thiết lập hiển thị.</div>
               <div class="block clearfix">
                  <div class="i-checks mr30" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($product['publish']) && $product['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
                        <label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
               <div class="block clearfix">
                  <div class="i-checks" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($product['publish']) && $product['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

                        <label for="no-publish" style="margin:0;cursor:pointer;">Không cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
