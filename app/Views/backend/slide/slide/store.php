<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $title; ?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Dashboard</a>
			</li>
			<li class="active"><strong>Quản lý Slide</strong></li>
		</ol>
	</div>
</div>

<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : ''; ?>
			</div>
		</div>
		<div class="row">
		   <?php echo view(route('backend.slide.slide.include.general')) ?>
			<button type="submit" name="create" value="create" class=" btn btn-primary block m-b pull-right">Lưu lại</button>
		</div>
		<div class="col-lg-3">
		   <?php echo view(route('backend.slide.slide.include.aside')) ?>
		</div>
	</div>
</div>
</form>
