<div class="col-lg-9 clearfix">
   <div class="ibox mb20">
      <div class="ibox-title" style="padding: 9px 15px 0px;">
         <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Thông tin cơ bản <small class="text-danger">Nhập đầy đủ các thông tin dưới đây</small></h5>
         </div>
      </div>
      <div class="ibox-content">
         <div class="row">
            <div class="col-lg-6 mb15">
               <div class="form-row">
                  <label class="control-label text-left">
                     <span>Tên Slide<b class="text-danger">(*)</b></span>
                  </label>
                  <?php  echo form_input('title', validate_input(set_value('title', (isset($slide[0]['title'])) ? $slide[0]['title'] : '')), 'class="form-control title" placeholder="" autocomplete="off"'); ?>
               </div>
            </div>
            <div class="col-lg-6 mb15">
               <div class="form-row">
                  <label class="control-label text-left">
                     <span>Từ Khóa<b class="text-danger">(*)</b></span>
                  </label>
                  <?php echo form_input('keyword', validate_input(set_value('keyword', (isset($slide[0]['keyword'])) ? $slide[0]['keyword'] : '')), 'class="form-control" '.((isset($slide[0]['keyword'])) ? 'readonly' : '').' placeholder="" autocomplete="off"'); ?>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-row form-description">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <label class="control-label text-left">
                        <span>Mô tả</span>
                     </label>
                  </div>
                  <?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($slide[0]['description'])) ? $slide[0]['description'] : ''))), 'class="form-control" id="description" placeholder="" autocomplete="off"');?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="ibox mb20 album">
      <div class="ibox-title">
         <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Album Ảnh </h5>
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
               <div class="edit">
                  <a onclick="SelectBanner($(this));return false;" href="" title="" class="upload-picture tv-button">Thêm ảnh slide mới</a>
               </div>
            </div>
         </div>
      </div>
      <div class="ibox-content">
         <?php
            $data = [];
            if(request()->getPost('slide')){
               $temp = request()->getPost('slide');
               foreach($temp['image'] as $key => $val){
                  $data[] = [
                     'slide_title' => $temp['title'][$key],
                     'slide_description' => $temp['description'][$key],
                     'canonical' => $temp['canonical'][$key],
                     'image' => $val
                  ];
               }
            }else if(isset($slide)){
               $data = $slide;
            }
         ?>
         <div class="row">
            <div class="col-lg-12">
               <div class="click-to-upload" <?php echo (isset($data) && is_array($data) && count($data))?'style="display:none"':'' ?>>
                  <div class="icon">
                     <a type="button" class="upload-picture" onclick="SelectBanner($(this));return false;">
                     <?php echo view(route('backend.slide.slide.include.svg')) ?>
                  </a>
               </div>
               <div class="small-text">Sử dụng nút thêm mới ảnh slide để thêm ảnh</div>
            </div>

            <div class="upload-list s-container" <?php echo (isset($data) && is_array($data) && count($data))?'':'style="display:none"' ?> style="padding:5px;">
               <div class="row">
                  <ul id="sortable" class="tv clearfix data-album sortui sort-slide">
                     <?php
                     if(isset($data) && is_array($data) && count($data)){ ?>
                     <?php foreach($data as $key => $val){ ?>
                     <li class="ui-state-default">
                         <div class="thumb">
                             <span class="image img-scaledown">
                                 <img src="<?php echo $val['image'] ?>" alt="">
                                 <input type="hidden" value="<?php echo $val['image'] ?>" class="value-img-banner" name="slide[image][]">
                             </span>
                             <div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div>
                             <div class="title"><input style="border:0;" placeholder="Tiêu đề" type="text" class="form-control" value="<?php echo $val['slide_title'] ?>" name="slide[title][]" /></div>
                             <div class="link"><input style="border:0;" value="<?php echo $val['canonical'] ?>" placeholder="Đường dẫn" type="text" class="form-control" name="slide[canonical][]" /></div>
                             <div class="description"><textarea style="height:98px;border:0;" placeholder="Nội dung" type="text" class="form-control" name="slide[description][]"><?php echo $val['slide_description'] ?></textarea></div>
                         </div>
                     </li>
                     <?php }}  ?>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
