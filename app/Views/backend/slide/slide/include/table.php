<table class="table table-striped table-bordered table-hover dataTables-example">
   <thead>
   <tr>
        <th style="width: 35px;">
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th >Tên Slide</th>
        <th >Từ khóa</th>

        <th class="text-center" style="width:103px;">Thao tác</th>
   </tr>
   </thead>
   <tbody>
        <?php if(isset($slide['list']) && is_array($slide['list']) && count($slide['list'])){ ?>
        <?php foreach($slide['list'] as $key => $val){ ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td class=" td-status" data-module="<?php echo $module; ?>" data-where="id"><?php echo isset($val['title'])? $val['title'] : ''; ?></td>
           <td class=" td-status"  data-module="<?php echo $module; ?>" data-where="id">
                <a href="<?php echo base_url('backend/slide/slide/update/'.$val['id'].'') ?>"><?php echo isset($val['keyword'])? $val['keyword'] : ''; ?></a>
            </td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url('backend/slide/slide/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a type="button" href="<?php echo base_url('backend/slide/slide/delete/'.$val['id']) ?>" class="btn js-btn-delete btn-danger" data-id="<?php echo $val['id'] ?>"><i class="fa fa-trash"></i></a>
           </td>
        </tr>
        <?php }}else{ ?>
           <tr>
                <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp</span></td>
           </tr>
        <?php } ?>

   </tbody>
</table>
<div id="pagination">
   <?php echo (isset($slide['pagination'])) ? $slide['pagination'] : ''; ?>
</div>
