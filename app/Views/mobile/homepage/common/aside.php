<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
    $language = $baseController->currentLanguage();
    $panel = get_panel([
		'locate' => 'sidebar',
		'language' => $language
	]);
	$slide = get_slide([
        'keyword' => 'aside',
        'language' => $language,
        'output' => 'array'
    ]);
?>

<aside class="aside">
	<?php
     $model = new App\Models\AutoloadModel();
     $category = $model->_get_where([
        'select' => 'tb1.id, tb2.title, tb2.canonical, tb1.icon',
        'table' => 'product_catalogue as tb1',
        'join' => [
           ['product_translate as tb2','tb1.id = tb2.objectid','inner']
        ],
        'where' => [
           'tb1.publish' => 1,
           'tb1.deleted_at' => 0,
           'tb2.module' => 'product_catalogue',
           'tb1.level' => 2
        ],
        'order_by' => 'order desc, id desc',
     ], TRUE);
     pre($category);
  ?>
  <div class="aside-category aside-panel mb30">
     <div class="aside-heading">Danh mục sản phẩm</div>
     <?php if(isset($category) && is_array($category) && count($category)){ ?>
     <ul class="uk-list uk-clearfix">
        <?php foreach($category as $key => $val){ ?>
        <li class="uk-flex uk-flex-middle">
           <span class="icon"><img src="<?php echo (!empty($val['icon'])) ? $detailCatalogue['icon'] : 'public/frontend/resources/img/icon-19.png'; ?>" alt=""></span>
           <a href="<?php echo write_url($val['canonical']); ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
        </li>
        <?php } ?>
     </ul>
     <?php } ?>
  </div>
</aside>
