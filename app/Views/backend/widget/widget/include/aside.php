<div class="ibox mb20">
   <div class="ibox-title">
      <h5 class="choose-image" style="cursor: pointer;">Cài đặt </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row mb15">
               <label class="mb5">Từ khóa</label>
               <?php echo form_input('keyword', htmlspecialchars_decode(html_entity_decode(set_value('keyword', (isset($widget['keyword'])) ? $widget['keyword'] : ''))), 'class="form-control" placeholder=""  autocomplete="off"');?>
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
               <div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($widget['image']) && $widget['image'] != '') ? $widget['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
               <?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($widget['image'])) ? $widget['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
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
                        <?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($widget['publish']) && $widget['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
                        <label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
               <div class="block clearfix">
                  <div class="i-checks" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($widget['publish']) && $widget['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

                        <label for="no-publish" style="margin:0;cursor:pointer;">Không cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
