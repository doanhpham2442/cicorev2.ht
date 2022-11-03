<div class="ibox-title" style="padding: 9px 15px 0px;">
   <div class="uk-flex uk-flex-middle uk-flex-space-between">
      <h5>Cài đặt thông số khuyến mãi </h5>
      <div class="ibox-tools">
         <button type="submit" name="save" value="save" class="btn btn-primary block full-width m-b">Lưu lại</button>
      </div>
   </div>
</div>
<div class="ibox-content">
   <div class="row mb15">
      <?php $type = (request()->getPost('type')) ? request()->getPost('type') : ( (isset($promotion['type'])) ? $promotion['type'] : '' );  ?>
      <div class="col-lg-6">
         <div class="form-row">
            <div class="discount-button_type <?php echo ($type == 'money') ? 'active' : '' ?>">
               <div class="discount-content">
                  <div class="uk-flex uk-flex-middle">
                     <span class="icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                     <span class="text">Giảm giá sản phẩm</span>
                     <input type="radio" value="money" name="type" class="hidden" <?php echo ($type == 'money') ? 'checked' : '' ?>>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <div class="form-row">
            <div class="discount-button_type <?php echo ($type == 'same') ? 'active' : '' ?>">
               <div class="discount-content">
                  <div class="uk-flex uk-flex-middle">
                     <span class="icon"><i class="fa fa-money" aria-hidden="true"></i></span>
                     <span class="text">Đồng giá sản phẩm</span>
                     <input type="radio" value="same" name="type" class="hidden" <?php echo ($type == 'same') ? 'checked' : '' ?>>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row discount-container">
       <?php $discountValue = (request()->getPost('discount_value')) ? request()->getPost('discount_value') : ( (isset($promotion['discount_value'])) ? $promotion['discount_value'] : 0 ); ?>
      <?php if($type == 'money'){ ?>
         <div class="col-lg-12 mt20">
            <div class="form-row">
               <label class="control-label text-left">
                  <span>Mức giảm </span>
               </label>
            </div>
         </div>
         <?php
            $discountType = (request()->getPost('discount_type')) ? request()->getPost('discount_type') : ( (isset($promotion['discount_type'])) ? $promotion['discount_type'] : '' )
         ?>
         <div class="col-lg-6 discount_block">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
               <div class="uk-flex uk-flex-middle">
                  <input type="text" name="discount_value" value="<?php echo $discountValue ?>" class="form-control discount-value int" placeholder="Nhập trị số giảm" autocomplete="off">
                  <select name="discount_type" class="nice-select ml10" style="display: none;">
                     <option value="money" <?php echo ($discountType == 'money') ? 'selected' : '' ?>>đ</option>
                     <option value="percent" <?php echo ($discountType == 'percent') ? 'selected' : '' ?>>%</option>
                  </select>
               </div>
            </div>
         </div>
      <?php } ?>
      <?php if($type == 'same'){ ?>
         <div class="col-lg-12 mt20">
            <div class="form-row">
               <label class="control-label text-left">
                  <span>Đồng giá</b>
                  </span>
               </label>
            </div>
         </div>
         <div class="col-lg-6 discount_block">
           <div class="uk-flex uk-flex-middle uk-flex-space-between">
             <div class="uk-flex uk-flex-middle">

               <input type="text" name="discount_value" value="<?php echo $discountValue ?>" class="form-control discount-value int" placeholder="Nhập trị số giảm" autocomplete="off">
             </div>
           </div>
         </div>
      <?php } ?>
   </div>
   <div class="row discount-object">
      <div class="col-lg-12 mt20">
         <div class="form-row">
            <label class="control-label text-left" style="margin-bottom:20px !important;"><span>Đối tượng áp dụng</span></label>
            <?php $module = (request()->getPost('object')) ? request()->getPost('object') : ( (isset($promotion['module'])) ? $promotion['module'] : '' ) ?>
            <div class="discount-item mb10">
               <div class="hrv-next-input-radio uk-flex uk-flex-middle">
                  <input id="4" name="object" type="radio" <?php echo ($module == 'product_catalogues') ? 'checked' : 'checked' ?> class="hrv-next-radio" style="margin-top:0;margin-right:10px;" value="product_catalogues">
                  <label class="hrv-next-label--switch" for="4" style="font-weight:normal;font-size:13px;">Nhóm Sản phẩm</label>
               </div>
            </div>
            <div class="discount-item">
               <div class="hrv-next-input-radio uk-flex uk-flex-middle">
                  <input id="3" name="object" type="radio" class="hrv-next-radio" <?php echo ($module == 'products') ? 'checked' : '' ?> value="products" style="margin-top:0;margin-right:10px;">
                  <label class="hrv-next-label--switch" for="3" style="font-weight:normal;font-size:13px;">Sản phẩm</label>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-12 search-discount">
         <div class="next-input--stylized">
            <div class="next-input-add-on next-input__add-on--before"><i class="fa fa-search"></i></div>
            <input autocomplete="on" type="text" class="next-input next-input--invisible" placeholder="Tìm kiếm" step="1" value="" data-start="0" data-module="<?php echo (request()->getPost('object')) ? request()->getPost('object') : ( (isset($promotion['module'])) ? $promotion['module'] : 'product_catalogues' ) ?>" data-limit="15">
            <input type="hidden" name="module" value="<?php echo (request()->getPost('object')) ? request()->getPost('object') : ( (isset($promotion['module'])) ? $promotion['module'] : 'product_catalogues' ) ?>" class="selected-module">
         </div>
         <div class="ui-popover-control hidden">
            <div class="ui-popover-dropdown">
               <div class="ui-popover-body">
                  <div class="object-list">

                  </div>
               </div>
               <div class="ui-popover-footer">
                  <div class="text-right">
                     <button class="btn btn-default previous" data-start=""  ><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                     <button class="btn btn-default next" data-start="" ><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-12 search-result">
         <div class="choose-collection">
            <?php if(isset($object) && is_array($object) && count($object)){ ?>
            <?php foreach($object as $key => $val){ ?>
               <div class="selected-item" id="product-'+data.id+'">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <div class="uk-flex uk-flex-middle">
                        <div class="s-image img-scaledown"><img src="<?php echo $val['image']  ?>" alt="<?php echo $val['title'] ?>"></div>
                        <div class="s-name"><a href="<?php echo write_url($val['canonical']) ?>" title=""><?php echo $val['title'] ?></a></div>
                        <input type="hidden" name="object_id[]" value="<?php echo $val['id']; ?>" />
                     </div>
                     <div class="deleted">
                        <svg class="svg-next-icon svg-next-icon-size-12" width="12" height="12"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18.263 16l10.07-10.07c.625-.625.625-1.636 0-2.26s-1.638-.627-2.263 0L16 13.737 5.933 3.667c-.626-.624-1.637-.624-2.262 0s-.624 1.64 0 2.264L13.74 16 3.67 26.07c-.626.625-.626 1.636 0 2.26.312.313.722.47 1.13.47s.82-.157 1.132-.47l10.07-10.068 10.068 10.07c.312.31.722.468 1.13.468s.82-.157 1.132-.47c.626-.625.626-1.636 0-2.26L18.262 16z"></path></svg></svg>
                     </div>
                  </div>
               </div>

            <?php }} ?>
         </div>
      </div>
   </div>
</div>
