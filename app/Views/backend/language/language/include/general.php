<div class="ibox mb20">
   <div class="ibox-title" style="padding: 9px 15px 0px;">
      <div class="uk-flex uk-flex-middle uk-flex-space-between">
         <h5>Thông tin cơ bản <small class="text-danger">Điền đầy đủ các thông tin được mô tả dưới đây</small></h5>
         <div class="ibox-tools">
            <button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
         </div>
      </div>
   </div>
   <div class="ibox-content">
      <div class="row mb15">
         <div class="col-lg-12">
            <div class="form-row">
               <label class="control-label text-left">
                  <span>Tiêu đề <b class="text-danger">(*)</b></span>
               </label>
               <?php echo form_input('title', validate_input(set_value('title', (isset($language['title'])) ? $language['title'] : '')), 'class="form-control title" placeholder="" id="title" autocomplete="off"'); ?>
            </div>
         </div>
      </div>
      <div class="row mb15">
         <div class="col-lg-12">
            <div class="form-row">
               <label class="control-label text-left">
                  <span>Từ Khóa <b class="text-danger">(*)</b></span>
               </label>
               <?php echo form_input('canonical', validate_input(set_value('canonical', (isset($language['canonical'])) ? $language['canonical'] : '')), 'class="form-control" placeholder=""  autocomplete="off"'); ?>
               <?php echo form_hidden('original_canonical', validate_input(set_value('original_canonical', (isset($language['canonical'])) ? $language['canonical'] : '')), 'class="form-control" placeholder=""  autocomplete="off"'); ?>
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
                  <a href="" title="" data-target="description" class="uploadMultiImage">Upload hình ảnh</a>
               </div>
               <?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($language['description'])) ? $language['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>

            </div>
         </div>
      </div>
   </div>
</div>
<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
