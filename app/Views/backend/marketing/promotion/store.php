<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $title; ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="">Trang chủ</a>
			</li>
			<li class="active"><strong><?php echo $title; ?></strong></li>
		</ol>
	</div>
</div>
<form method="post" action="" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-8 clearfix">
				<div class="ibox mb20">
               <div class="ibox-title" style="padding: 9px 15px 0px;">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <h5>Thêm mới chương trình giảm giá <small class="text-danger"> Nhập đầy đủ các thông tin dưới đây</small></h5>
                     <div class="ibox-tools">
                        <button type="submit" name="save" value="save" class="btn btn-primary block full-width m-b">Lưu lại</button>
                     </div>
                  </div>
               </div>
				   <?php echo view(route('backend.marketing.promotion.include.general')) ?>
				</div>
            <div class="ibox mb20">
               <?php echo view(route('backend.marketing.promotion.include.setting')) ?>
            </div>
				<div class="ibox mb20 album">
	            <?php echo view(route('backend.marketing.promotion.include.gallery')) ?>
				</div>

				<div class="ibox ibox-seo mb20">
				    <?php echo view(route('backend.marketing.promotion.include.seo')) ?>

				</div>
				<button type="submit" name="save" value="save" class="btn btn-primary block m-b pull-right">Lưu lại</button>

			</div>
			<div class="col-lg-4">
	          <?php echo view(route('backend.marketing.promotion.include.aside')) ?>
			</div>
		</div>
	</div>
</form>
