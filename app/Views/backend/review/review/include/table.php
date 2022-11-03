<table class="table table-striped table-bordered table-hover dataTables-example">
   <thead>
   <tr>
        <th>
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th>Họ Tên</th>
        <th>Email</th>
        <th class="text-center">Nội dung</th>
        <th class="text-center">Đánh giá</th>
        <th class="text-center">Tình trạng</th>
        <th class="text-center">Thao tác</th>
   </tr>
   </thead>
   <tbody>
        <?php if(isset($review['list']) && is_array($review['list']) && count($review['list'])){ ?>
        <?php foreach($review['list'] as $key => $val){ ?>
        <?php
           $fullname = ($val['fullname'] != '') ? $val['fullname'] : '-';
           $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
        ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td><?php echo $fullname ?></td>
           <td><?php echo $val['email'] ?></td>
           <td><?php echo $val['description'] ?></td>
           <td class="text-center"><?php echo $val['rate'] ?> <i style="color:#ff9400" class="fa fa-star"></i> </td>
           <td class="text-center td-status" data-field="publish" data-module="<?php echo $module; ?>"><?php echo $status; ?></td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url('backend/review/review/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
   <?php echo (isset($review['pagination'])) ? $review['pagination'] : ''; ?>
</div>
