<table class="table table-striped table-bordered table-hover dataTables-example">
    <thead>
    <tr>
        <th style="width: 35px;">
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th >Tiêu đề nhóm</th>
        <th class="text-center" style="width:103px;">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        <?php if(isset($userCatalogue['list']) && is_array($userCatalogue['list']) && count($userCatalogue['list'])){ ?>
        <?php foreach($userCatalogue['list'] as $key => $val){ ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td><?php echo $val['title'] ?></td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url('backend/user/catalogue/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a type="button" href="<?php echo base_url('backend/user/catalogue/delete/'.$val['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
    <?php echo (isset($userCatalogue['pagination'])) ? $userCatalogue['pagination'] : ''; ?>
</div>
