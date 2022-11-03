<?php
	helper(['mydatafrontend','mydata']);
	$baseController = new App\Controllers\FrontendController();
	$model = new App\Models\AutoloadModel();
	$language = $baseController->currentLanguage();

	$article = $model->_get_where([
		'select' => 'tb1.id, tb2.title, tb2.canonical, tb1.image, tb1.created_at',
		'table' => 'article as tb1',
		'join' => [
			['article_translate as tb2','tb1.id = tb2.objectid','inner']
		],
		'where' => [
			'tb1.publish' => 1,
			'tb1.deleted_at' => 0,
			'tb2.module' => 'article'
		],
		'limit' => 8,
		'order_by' => 'id desc'
	], TRUE);

?>
<aside>
    <h3 class="title"><span>Bài viết mới</span></h3>
	 <?php if(isset($article) && is_array($article) && count($article)){ ?>
    <ul class="aside-box uk-list uk-clearfix">
		 <?php foreach($article as $key => $val){ ?>
        <li class="post-box">
            <div class="uk-flex uk-flex-middle">
                <div class="thumb"><a class="image img-cover" href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                <div class="info">
                    <h3 class="title"><a  href="<?php echo write_url($val['canonical']); ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h3>
                    <div class="meta"><i class="fa fa-clock-o"></i>  <?php echo gettime($val['created_at']); ?></div>
                </div>
            </div>
        </li>
	  	<?php } ?>
    </ul>
 	<?php } ?>
</aside>
