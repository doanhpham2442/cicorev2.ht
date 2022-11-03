<div class="cart-checkpage">
   <div class="cart-check-content">
        <div class="container-check-cart">
            <div class="panel-check">
                <div class="panel-head uk-text-center">
                    <h1 class="heading-1"><span>Đặt Hàng Thành Công!</span></h1>
                    <div class="description">
                       <?php echo $general['cart_welcome']  ?>
                    </div>
                    <div class="btn-more"><a href="" title="">Khám phá thêm các sản phẩm khác tại đây</a></div>
                </div>
                <div class="panel-body mb30">
                    <h2 class="title uk-text-center"><span>Thông tin đơn hàng</span></h2>
                    <div class="check-box">
                        <div class="check-box-head">
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-small-1-1 uk-width-medium-1-3"></div>
                                <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                    <div class="order-title uk-text-center">ĐƠN HÀNG #<?php echo $order['code'] ?></div>
                                </div>
                                <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                    <div class="order-date"><?php echo changeDateFormat($order['created_at'],'H:i d/m/Y') ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="check-box-body">
                            <table class="table" style="overflow-x:auto;">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th width="120px">Giá niêm yết</th>
                                        <th class="text--right">Thành tiền</th>
                                    </tr>
                                </thead>
                                <?php $totalVoucherDiscount = 0; $total = 0; ?>
                                <?php if(isset($orderDetail) && is_array($orderDetail) && count($orderDetail)){ ?>
                                <tbody>
                                   <?php foreach($orderDetail as $key => $val){ ?>
                                    <?php
                                       $option = json_decode(json_decode($val['option'], TRUE), TRUE);
                                       $subTotal = 0;
                                       if(isset($option['voucher'])){
                                          $totalVoucherDiscount = $totalVoucherDiscount + $option['voucher']['voucherDiscountValue'];
                                       }
                                       $subTotal = $subTotal + ($val['quantity']*$val['price']);

                                       if(isset($option['voucher']) && $option['voucher']['voucherDiscountValue'] > 0){
                                          if($option['voucher']['voucherDiscountType'] == 'percent'){
                                             $subTotal = $subTotal - ($subTotal*$option['voucher']['voucherDiscountValue']/100);
                                          }else if($option['voucher']['voucherDiscountType'] == 'money'){
                                             $subTotal = $subTotal - $option['voucher']['voucherDiscountValue'];
                                          }
                                       }

                                       $total = $total + $subTotal;


                                    ?>
                                    <tr>
                                        <td class="text--left">
                                           <?php echo $val['name'] ?>
                                        </td>
                                        <td><?php echo $val['quantity'] ?></td>
                                        <td>
                                            <?php echo commas($val['price']) ?>đ
                                        </td>

                                        <td><?php echo commas($subTotal); ?>đ</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                              <?php } ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            Mã giảm giá
                                        </td>
                                        <td><?php echo (isset($order['voucher'])) ? $order['voucher'] : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Tổng giá trị sản phẩm
                                        </td>
                                        <td>
                                            <?php echo commas($total + $totalVoucherDiscount); ?>đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            Tổng khuyến mãi
                                        </td>
                                        <td>
                                            <?php echo ($totalVoucherDiscount > 0) ? commas($totalVoucherDiscount)  : commas($order['voucherDiscountValue']); ?>đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Phí giao hàng</td>
                                        <td>0đ</td>
                                    </tr>
                                    <tr class="total_payment">
                                        <td colspan="3">
                                            Tổng thanh toán
                                        </td>
                                        <td>
                                            <?php echo commas($total) ?>đ
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-foot">
                    <h2 class="title uk-text-center mb20"><span>Thông tin nhận hàng</span></h2>
                    <div class="check-box">
                        <div class="name mb10">Tên người nhận: <span><?php echo $order['fullname'] ?></span></div>
                        <div class="email mb10">Email: <span><?php echo $order['email'] ?></span></div>
                        <div class="phone mb10">Số điện thoại: <span><?php echo $order['phone'] ?></span></div>
                        <div class="payment mb10">Hình thức thanh toán: <span>Thanh toán khi nhận hàng (COD)</span></div>
                        <div class="address mb10">Địa chỉ nhận hàng: <span><?php echo $order['address']; ?></span></div>
                    </div>
                    <div class="ending-text uk-text-center">Hãy bảo vệ sức khoẻ của bạn và cộng đồng!</div>
                </div>
            </div>
        </div>
   </div>
</div>
