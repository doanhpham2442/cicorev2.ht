<div class="ibox mb20 variants">
   <div class="ibox-title">
      <div><h5 style="display:block;float:none;">Phiên bản sản phẩm </h5></div>
      <div class="description">
         Cho phép bạn bán các phiên bản khác nhau của sản phẩm, ví dụ: quần, áo thì có các <strong>màu sắc</strong> và <strong>size</strong> số khác nhau. Mỗi phiên bản sẽ là 1 dòng trong mục danh sách phiên bản phía dưới.
      </div>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="discount-new-timer uk-flex uk-flex-middle">
               <input type="checkbox" class="next-checkbox" name="accept" id="variantContainer">
               <label class="next-label--switch turnOnVariant" for="variantContainer">Sản phẩm này có nhiều biến thể. Ví dụ như khác nhau về màu sắc, kích thước</label>
            </div>
         </div>
      </div>
      <div class="variantContainer ">
         <div class="row">
            <div class="col-lg-3">
               <div class="attributeCatalogue">
                  <div class="attributeTitle">Chọn thuộc tính</div>
               </div>
            </div>
            <div class="col-lg-9">
               <div class="attributeTitle">Giá trị thuộc tính ( Nhập 2 chữ cái để tìm kiếm )</div>
            </div>
         </div>
         <div class="variantItemContainer">

         </div>
         <button href="" class="add-variant addVariant active mt10">
            Thêm mới phiên bản
         </button>
      </div>
   </div>
</div>
<div class="ibox mb20 variantList">
   <div class="ibox-title">
      <div><h5 style="display:block;float:none;">Danh sách phiên bản </h5></div>
   </div>
   <div class="ibox-content">
      <div class="table-responsive">
         <table class="table table-striped variantTable" >
            <thead>
               <tr>
                  <td>Hình Ảnh</td>
                  <td>Màu sắc</td>
                  <td>Chất liệu</td>
                  <td>Kích thước</td>
                  <td class="text-right">Số lượng</td>
                  <td class="text-right">Giá Tiền</td>
                  <td class="text-right">SKU</td>
               </tr>
            </thead>
            <tbody>
               <?php for($i = 0; $i<=1; $i++){ ?>
               <tr class="tr-item">
                 <td>
                    <span class="image img-cover"><img src="https://daks2k3a4ib2z.cloudfront.net/6343da4ea0e69336d8375527/6343da5f04a965c89988b149_1665391198377-image16-p-500.jpg" alt=""></span>
                 </td>
                 <td>Xanh lá</td>
                 <td>Vàng</td>
                 <td>12mm</td>
                 <td class="text-right td-quantity">∞</td>
                 <td class="text-right td-price"><span class="int">1.000.000</span></td>
                 <td class="text-right td-sku">123324327</td>
               </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<script type="text/javascript">
   var attributeCatalogue = '<?php echo json_encode($attributeCatalogue) ?>';

</script>
