<?php
use App\Models\AutoloadModel;

if (! function_exists('authentication')){
	function authentication(){
		$model = new AutoloadModel();
	 	$auth = (isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '';
	 	$auth = json_decode($auth, TRUE);
	 	$user = $model->_get_where([
	       	'select' => 'tb1.id, tb1.email, tb1.phone, tb1.address,tb1.image,tb1.fullname,tb1.user_catalogue_id,( SELECT tb2.title FROM user_catalogues as tb2 WHERE tb1.user_catalogue_id = tb2.id) as `job`',
	       	'table' => 'users as tb1',
	       	'where' => ['email' => $auth['email']]
   		]);
	 	return $user;

	}
}

?>
