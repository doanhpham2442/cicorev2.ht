<!DOCTYPE html>
<html lang="vi-VN">
	<head>
		<?php echo $general['analytic_google_analytic'] ?>
		<?php echo $general['facebook_facebook_pixel'] ?>
		<!-- CONFIG -->
		<base href="<?php echo BASE_URL ?>" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow" />
		<meta name="author" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta name="copyright" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta http-equiv="refresh" content="1800" />
		<link rel="icon" href="<?php echo $general['homepage_favicon'] ?>" type="image/png" sizes="30x30">
		<!-- GOOGLE -->
		<title><?php echo isset($seo['meta_title'])?htmlspecialchars($seo['meta_title']):'';?></title>
		<meta name="description"  content="<?php echo isset($seo['meta_description'])?htmlspecialchars($seo['meta_description']):'';?>" />
		<?php echo isset($seo['canonical'])?'<link rel="canonical" href="'.$seo['canonical'].'" />':'';?>
		<meta property="og:locale" content="vi_VN" />
		<!-- for Facebook -->
		<meta property="og:title" content="<?php echo (isset($seo['meta_title']) && !empty($seo['meta_title']))?htmlspecialchars($seo['meta_title']):'';?>" />
		<meta property="og:type" content="<?php echo (isset($og_type) && $og_type != '') ? $og_type : 'article'; ?>" />
		<meta property="og:image" content="<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? $seo['meta_image'] : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
		<?php echo isset($seo['canonical'])?'<meta property="og:url" content="'.$seo['canonical'].'" />':'';?>
		<meta property="og:description" content="<?php echo (isset($seo['meta_description']) && !empty($seo['meta_description']))?htmlspecialchars($seo['meta_description']):'';?>" />
		<meta property="og:site_name" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta property="fb:admins" content=""/>
		<meta property="fb:app_id" content="" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo isset($seo['meta_title'])?htmlspecialchars($seo['meta_title']):'';?>" />
		<meta name="twitter:description" content="<?php echo (isset($seo['meta_description']) && !empty($seo['meta_description']))?htmlspecialchars($seo['meta_description']):'';?>" />
		<meta name="twitter:image" content="<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image']))?$seo['meta_image']:base_url((isset($general['homepage_logo'])) ? $general['homepage_logo']  : '');?>" />
		<?php echo view('frontend/homepage/common/head') ?>
      <link href="public/backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
      <link rel="stylesheet" href="public/frontend/core/plugins/jquery-nice-select-1.1.0/css/nice-select.css">
      <?php
         if(isset($css) && is_array($css) && count($css)){
            foreach($css as $key => $val){
               echo '<link href="public/frontend/core/'.$val.'.css" rel="stylesheet">';
            }
         }
      ?>
		<script type="text/javascript">
			  var BASE_URL = '<?php echo BASE_URL; ?>';
		 </script>

	</head>
	<body class="homepage">
		<?php echo view('frontend/homepage/common/header') ?>
		<div class="page-wrapper">
			<main class="main">
				<?php echo view((isset($template)) ? $template : '') ?>
			</main>
		</div>
		<?php echo view('frontend/homepage/common/footer') ?>
		<?php echo view('backend/dashboard/common/notification') ?>
		<!-- Tao Widget -->
		<?php echo view('frontend/homepage/common/script') ?>
      <script src="public/backend/js/plugins/toastr/toastr.min.js"></script>
      <script src="public/frontend/core/plugins/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js"></script>
      <?php
         if(isset($js) && is_array($js) && count($js)){
            foreach($js as $key => $val){
               echo '<script type="text/javascript" src="public/frontend/core/library/'.$val.'.js" ></script>';
            }
         }
      ?>

	</body>
</html>
