<div class="ibox mb20">
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
         <?php
            $typeList = VOUCHER_TYPE;
            $type = (request()->getPost('type')) ? request()->getPost('type') : ( (isset($voucher['type'])) ? $voucher['type'] : '' );
         ?>
         <?php foreach($typeList as $key => $val){ ?>
         <div class="col-lg-6 mb10">
            <div class="form-row">
               <div class="discount-button_type <?php echo ($type == $val['name']) ? 'active' : '' ?>">
                  <div class="discount-content">
                     <div class="uk-flex uk-flex-middle">
                        <span class="icon"><?php echo $val['icon'] ?></span>
                        <span class="text"><?php echo $val['title'] ?></span>
                        <input type="radio" value="<?php echo $val['name'] ?>" name="type" class="hidden" <?php echo ($type == $val['name']) ? 'checked' : '' ?>>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php } ?>
      </div>
      <div class="row discount-container">
          <?php $discountValue = (request()->getPost('discount_value')) ? request()->getPost('discount_value') : ( (isset($voucher['discount_value'])) ? $voucher['discount_value'] : 0 ); ?>
         <?php if($type == 'money' || $type == 'bill' || $type == 'ship'){ ?>
            <div class="col-lg-12 mt20">
               <div class="form-row">
                  <label class="control-label text-left">
                     <span>Mức giảm </span>
                  </label>
               </div>
            </div>
            <?php
               $discountType = (request()->getPost('discount_type')) ? request()->getPost('discount_type') : ( (isset($voucher['discount_type'])) ? $voucher['discount_type'] : '' )
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


      <div class="row discount-object" <?php echo (isset($voucher['type']) && ($voucher['type'] == 'bill' || $voucher['type'] == 'ship'))  ? 'style="display:none;"' : ''; ?>>
         <div class="col-lg-12 mt20">
            <div class="form-row">
               <label class="control-label text-left" style="margin-bottom:20px !important;"><span>Đối tượng áp dụng</span></label>
               <?php $module = (request()->getPost('object')) ? request()->getPost('object') : ( (isset($voucher['module'])) ? $voucher['module'] : '' ) ?>
               <div class="discount-item mb10">
                  <div class="hrv-next-input-radio uk-flex uk-flex-middle">
                     <input id="4" name="object" type="radio" <?php echo ($module == 'product_catalogues') ? 'checked' : 'checked' ?> class="hrv-next-radio" style="margin-top:0;margin-right:10px;" value="product_catalogues">
                     <label class="hrv-next-label--switch" for="4" style="font-weight:normal;font-size:14px;">Nhóm Sản phẩm</label>
                  </div>
               </div>
               <div class="discount-item">
                  <div class="hrv-next-input-radio uk-flex uk-flex-middle">
                     <input id="3" name="object" type="radio" class="hrv-next-radio" <?php echo ($module == 'products') ? 'checked' : '' ?> value="products" style="margin-top:0;margin-right:10px;">
                     <label class="hrv-next-label--switch" for="3" style="font-weight:normal;font-size:14px;">Sản phẩm</label>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12 search-discount">
            <div class="next-input--stylized">
               <div class="next-input-add-on next-input__add-on--before"><i class="fa fa-search"></i></div>
               <input autocomplete="on" type="text" class="next-input next-input--invisible" placeholder="Tìm kiếm" step="1" value="" data-start="0" data-module="<?php echo (request()->getPost('object')) ? request()->getPost('object') : ( (isset($voucher['module'])) ? $voucher['module'] : 'product_catalogues' ) ?>" data-limit="15">
               <input type="hidden" name="module" value="<?php echo (request()->getPost('object')) ? request()->getPost('object') : ( (isset($voucher['module'])) ? $voucher['module'] : 'product_catalogues' ) ?>" class="selected-module">
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
</div>
<div class="ibox mb20 bil-container">
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="mb20"><strong>Điều kiện áp dụng</strong></div>
         </div>
         <?php
            $billCondition = [
               0 => [
                  'name' => 'Không yêu cầu',
               ],
               1 => [
                  'name' => 'Giá trị mua tối thiểu',
               ],
               2 => [
                  'name' => 'Số lượng sản phẩm tối thiểu',
               ],
            ];

            $billConditionPost = ( request()->getPost('billCondition') ) ? request()->getPost('billCondition') : ( (isset($voucher['billCondition'])) ? $voucher['billCondition'] : '' );

            $billConditionValue = ( request()->getPost('billConditionValue') ) ? request()->getPost('billConditionValue') : ( (isset($voucher['billConditionValue'])) ? $voucher['billConditionValue'] : '' );


            if(isset($billCondition) && is_array($billCondition) && count($billCondition)){
               foreach($billCondition as $key => $val){
                  if($billConditionPost == $val['name'] && $val['name'] != 'Không yêu cầu'){
                     $billCondition[$key]['afterPost'] = 1;
                     $billCondition[$key]['billConditionValue'] = $billConditionValue;
                  }
               }
            }


         ?>
         <div class="col-lg-12">
            <?php $billConditionValue = (request()->getPost('billCondition')) ? request()->getPost('billCondition') : ( (isset( $voucher['billCondition'] )) ? $voucher['billCondition'] : 'Không yêu cầu' ); ?>
            <?php foreach($billCondition as $key => $val){ ?>
            <div class="bill-container-item mb10" for="<?php echo $key; ?>">
               <div class="hrv-next-input-radio uk-flex uk-flex-middle">
                  <input id="<?php echo $key; ?>" name="billCondition" type="radio" class="hrv-next-radio" style="margin-top:0;margin-right:10px;" value="<?php echo $val['name'] ?>" <?php echo ($billConditionValue == $val['name']) ? 'checked' : '' ?>>
                  <label class="hrv-next-label--switch bill-condition-switch" for="<?php echo $key; ?>" style="font-weight:normal;font-size:14px;"><?php echo $val['name'] ?></label>
               </div>
               <?php if(isset($val['afterPost']) && $val['afterPost'] == 1 ){ ?>
               <div class="w-50 discount-channel--option mb-4">
                  <div class="my-4">
                     <input name="billConditionValue" class="next-input text-left min-width-100px int" placeholder="0 ₫" value="<?php  echo $val['billConditionValue'] ?>"></div>
                     <span class="text-secondary">Áp dụng cho  <span class="text-lowercase">Tất cả đơn hàng</span></span>
                  </div>
               <?php } ?>

            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<div class="ibox mb20">
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="mb20"><strong>Giới hạn sử dụng</strong></div>
         </div>
         <div class="col-lg-12">
            <div class="discount-new-timer uk-flex uk-flex-middle">
               <input type="checkbox" class="next-checkbox"  name="countLimit" id="countLimit" checked>
               <label data-flag="0" class="next-label--switch" for="countLimit">Giới hạn số lần tối đa chương trình này được áp dụng</label>
            </div>
            <div class="my-4 w-50">
               <?php $countLimitValue = (request()->getPost('countLimitValue')) ? request()->getPost('countLimitValue') : ( (isset($voucher['countLimitValue'])) ? $voucher['countLimitValue'] : 0 ) ?>
               <input
                  type="number"
                  name="countLimitValue"
                  class="next-input text-left min-width-100px int"
                  value="<?php echo $countLimitValue; ?>"
               >
            </div>
            <div class="discount-new-timer uk-flex uk-flex-middle">
               <input type="checkbox" class="next-checkbox"  name="countCustomer" id="countCustomer" checked="">
               <label data-flag="0" class="next-label--switch" for="countCustomer">Giới hạn số lần sử dụng cho mỗi khách hàng</label>
            </div>
            <div class="my-4 w-50">
               <?php $countCustomerValue = (request()->getPost('countCustomerValue')) ? request()->getPost('countCustomerValue') : ( (isset($voucher['countCustomerValue'])) ? $voucher['countCustomerValue'] : 0 ) ?>
               <input
                  type="number"
                  name="countCustomerValue"
                  class="next-input text-left min-width-100px int"
                  value="<?php echo $countCustomerValue; ?>"
               >
            </div>
            <div class="discount-new-timer uk-flex uk-flex-middle">
               <?php $allowCoupon = (request()->getPost('allowCoupon')) ? request()->getPost('allowCoupon') : ( (isset($voucher['allowCoupon'])) ? $voucher['allowCoupon'] : 0 ) ?>
               <input
                  type="checkbox"
                  class="next-checkbox"
                  name="allowCoupon"
                  value="1"
                  id="allowCoupon"
                  <?php echo ($allowCoupon == 1) ? 'checked' : '' ?>
               >
               <label class="next-label--switch" for="allowCoupon">Cho phép sử dụng chung với chương trình khuyến mãi</label>
            </div>
         </div>
      </div>
   </div>
</div>
