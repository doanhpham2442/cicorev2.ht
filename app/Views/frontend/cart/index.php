<script>
   var cityid = '<?php echo (request()->getPost('city_id')) ? request()->getPost('city_id') : '' ?>';
   var districtid = '<?php echo (request()->getPost('district_id')) ? request()->getPost('district_id') : '' ?>';
   var wardid = '<?php echo (request()->getPost('ward_id')) ? request()->getPost('ward_id') : '' ?>';
</script>
<div class="cart-detailpage">
   <form action="" method="post">

      <div class="cart-detail-content">
           <div class="container-cart">

               <div class="uk-grid uk-grid-medium">
                   <div class="uk-width-small-1-1 uk-width-medium-3-5">
                       <div class="cart-info">
                           <div class="cart-head uk-flex uk-flex-middle uk-flex-space-between">
                               <h2 class="heading-2"><span>Thông tin vận chuyển</span></h2>
                               <div class="btn-login">Bạn đã có tài khoản ? <a href="" title="">Đăng nhập ngay</a></div>
                           </div>
                           <div class="cart-body">
                              <div class="uk-grid uk-grid-medium mb20">
                                 <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                      <div class="form-field">
                                          <?php echo form_input('fullname', set_value('fullname'), 'class="form-control" placeholder="Họ Tên"'); ?>
                                          <?php if($validate != null && !empty($validate->getError('fullname'))){ ?>
                                          <span class="error">* <?php echo  $validate->getError('fullname'); ?></span>
                                          <?php } ?>
                                      </div>
                                 </div>
                                 <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                    <div class="form-field">
                                        <?php echo form_input('phone', set_value('phone'), 'class="form-control" placeholder="Số điện thoại"'); ?>
                                        <?php if($validate != null && !empty($validate->getError('phone'))){ ?>
                                        <span class="error">* <?php echo  $validate->getError('phone'); ?></span>
                                        <?php } ?>
                                    </div>
                                 </div>
                             </div>
                             <div class="form-field mb20">
                                <?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"'); ?>
                                <?php if($validate != null  && !empty($validate->getError('email'))){ ?>
                                <span class="error">* <?php echo  $validate->getError('email'); ?></span>
                                <?php } ?>
                            </div>
                            <div class="form-field mb20">
                               <?php echo form_input('address', set_value('address'), 'class="form-control" placeholder="Địa chỉ (ví dụ: 103 Vạn Phúc, phường Vạn Phúc)"'); ?>
                               <?php if($validate != null && !empty($validate->getError('address'))){ ?>
                               <span class="error">* <?php echo  $validate->getError('address'); ?></span>
                               <?php } ?>
                            </div>
                             <div class="uk-grid uk-grid-medium mb20">
                                 <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                      <div class="form-field">
                                           <?php echo form_dropdown('city_id', $province, set_value('city_id'), 'id="city" class="niceSelect"');?>
                                           <?php if($validate != null && !empty($validate->getError('city_id'))){ ?>
                                           <span class="error">* <?php echo  $validate->getError('city_id'); ?></span>
                                           <?php } ?>
                                      </div>
                                 </div>
                                 <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                      <div class="form-field">
                                           <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="niceSelect" id="district"');?>
                                           <?php if($validate != null && !empty($validate->getError('district_id'))){ ?>
                                           <span class="error">* <?php echo  $validate->getError('district_id'); ?></span>
                                           <?php } ?>
                                      </div>
                                 </div>
                                 <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                      <div class="form-field">
                                          <?php echo form_dropdown('ward_id', ['Chọn Phường/Xã'], set_value('ward_id'), 'class="niceSelect" id="ward"');?>
                                      </div>
                                 </div>
                             </div>
                             <div class="form-field">
                                 <input type="text" name="description" placeholder="Ghi chú thêm (Ví dụ: Giao hàng giờ hành chính)" class="form-control">
                             </div>
                           </div>
                           <div class="cart-foot">
                               <h2 class="heading-2 mb20"><span>Hình thức thanh toán</span></h2>
                               <?php $paymentMethod = paymentMethod() ?>
                               <div>
                                  <?php foreach($paymentMethod as $key => $val){ ?>
                                   <label for="<?php echo $val['method'] ?>" class="uk-flex" >
                                       <input type="radio" id="<?php echo $val['method'] ?>" value="zalo" name="paymentMethod" <?php echo ($key != 0) ? 'disabled' : '' ?> <?php echo ($key == 0) ? 'checked' : '' ?>>
                                       <span class="radio-img"><img src="<?php echo $val['img'] ?>" alt=""></span>
                                       <span class="item-name"><?php echo $val['name'] ?></span>
                                   </label>
                                    <?php } ?>
                                   <div class="cart-return-text">
                                       Nếu bạn không hài lòng với sản phẩm của chúng tôi? Bạn hoàn toàn có thể trả lại sản phẩm.
                                       Tìm hiểu thêm <a href="" target="_blank"><b>tại đây</b></a>.
                                   </div>
                                   <button type="submit" name="create" value="create" class="checkout-btn"> Thanh toán đơn hàng</button>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="uk-width-small-1-1 uk-width-medium-2-5">
                       <?php echo view(route('frontend.cart.include.cart')) ?>
                   </div>
               </div>
           </div>
      </div>
   </form>
</div>
