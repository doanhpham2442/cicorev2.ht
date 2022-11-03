<table class="table table-striped table-bordered table-hover dataTables-example">
   <thead>
   <tr>
        <th>
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th>Mã</th>
        <th>Ngày tạo</th>
        <th>Khách hàng</th>
        <th>Thanh toán</th>
        <th class="text-center">Giao hàng</th>
        <th class="text-center">COD</th>
        <th class="text-right">Tổng tiền</th>
   </tr>
   </thead>
   <tbody>
         <?php
            $totalVoucherDiscount = 0;
            if(isset($order['list']) && is_array($order['list']) && count($order['list'])){
            foreach($order['list'] as $key => $val){
               $cart = json_decode($val['cart'], TRUE);
               $detail = $val['detail'];
               $subTotal = 0;
               if(isset($detail) && is_array($detail) && count($detail)){
                  foreach($detail as $details){
                     $option = json_decode(json_decode($details['option'], TRUE), TRUE);
                     if(isset($option['voucher'])){
                        $totalVoucherDiscount = $totalVoucherDiscount + $option['voucher']['voucherDiscountValue'];
                     }
                     $subTotal = $subTotal + ($details['quantity']*$details['price']);
                  }
               }
               if($val['voucherDiscountValue'] > 0){
                  if($val['voucherDiscountType'] == 'percent'){
                     $subTotal = $subTotal - ($subTotal*$val['voucherDiscountValue']/100);
                  }else if($val['voucherDiscountType'] == 'money'){
                     $subTotal = $subTotal - $val['voucherDiscountValue'];
                  }
               }
         ?>
        <?php
           $fullname = ($val['fullname'] != '') ? $val['fullname'] : '-';
           $status = ($val['status'] == 1) ? '<span class="text-success">Đã giao</span>'  : '<span class="text-danger">Chưa giao</span>';
        ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td><a href="<?php echo base_url(route('backend.order.order.detail')).'/'.$val['id'] ?>"><?php echo $val['code'] ?></a></td>
            <td><?php echo changeDateFormat($val['created_at'],'d-m-Y H:i') ?></td>
           <td>
              <a href="" onclick="return false;">Họ Tên: <?php echo $fullname ?></a><br>
              <a href="" onclick="return false;">Số điện thoại: <?php echo $val['phone'] ?></a>
           </td>
           <td><?php echo ($val['payment'] == 1) ? 'Đã Thanh Toán'  : 'Chưa Thanh Toán' ?></td>
            <td class="text-center td-status" data-field="status" data-module="<?php echo $module; ?>"><?php echo $status; ?></td>
           <td class="text-center"> Không thu COD </td>
           <td class="text-right">
               <?php echo commas($subTotal - $totalVoucherDiscount) ?> đ
           </td>
        </tr>
        <?php }}else{ ?>
           <tr>
                <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
           </tr>
        <?php } ?>
   </tbody>
</table>
<div id="pagination">
   <?php echo (isset($order['pagination'])) ? $order['pagination'] : ''; ?>
</div>
