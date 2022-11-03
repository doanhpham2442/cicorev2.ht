<?php
namespace App\Libraries;
use App\Models\AutoloadModel;

class Authentication{

	public $auth;
	protected $AutoloadModel;

	public function __construct(){
		$this->auth = ((isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '');
		$this->AutoloadModel = new AutoloadModel();
	}

	public function check_auth(){
 		return json_decode($this->auth, TRUE);
	}

	public function check_permission(array $param = []){
		$session = session();
		$this->auth = json_decode($this->auth, TRUE);
		if($this->auth == ''){
 			return false;
		}
		$user = $this->AutoloadModel->_get_where([
			'select' => 'tb2.permission',
			'table' => 'users as tb1',
			'join' => [
				['user_catalogues as tb2', 'tb1.user_catalogue_id = tb2.id', 'inner']
			],
			'where' => ['tb1.id' => $this->auth['id']]
		]);

		$permission = json_decode($user['permission'], TRUE);
		if(in_array($param['routes'], $permission) == false){
			return false;
		}
		return true;

	}

   public static function id(){
      $auth = ((isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '');
      $auth = json_decode($auth, TRUE);
      return $auth['id'];
   }

   public function gate(string $allowUrl = ''){
      $flag = $this->check_permission([
         'routes' => route($allowUrl),
      ]);
      return $flag;

   }

}
