
<div class="ibox-content">
   <div class="row mb15">
      <div class="col-lg-12">
         <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
               <label class="control-label text-left">
                  <span>Mã khuyến mãi <b class="text-danger">(*)</b></span>
               </label>
               <a href="" title="" data-target="description" class="renderVoucher">Tạo Mã Tự Động</a>
            </div>
            <?php echo form_input('title', validate_input(set_value('title', (isset($voucher['title'])) ? $voucher['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
         </div>
      </div>
   </div>
   <div class="row mb15">
      <div class="col-lg-12">
         <div class="form-row form-description">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
               <label class="control-label text-left">
                  <span>Mô tả ngắn</span>
               </label>
               <a href="" title="" data-target="description" class="uploadMultiImage">Click để upload hình ảnh</a>
            </div>
            <?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($voucher['description'])) ? $voucher['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>

         </div>
      </div>
   </div>
</div>
