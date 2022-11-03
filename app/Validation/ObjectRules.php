<?php
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class ObjectRules {

	protected $AutoloadModel;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	public function check_canonical(string $canonical = '', string $module = ''): bool{
		$originalCanonical = $this->request->getPost('original_canonical');
		$modulExtract = explode('_', $module);
		$dem = 0;
		if($originalCanonical != $canonical){
			$dem = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => 'routers',
				'where' => ['canonical' => $canonical],
				'count' => TRUE
			]);
		}
		if( $dem > 0){
			return false;
		}
		return true;
 	}


 	public function check_router(string $canonical = ''): bool{
		$originalCanonical = $this->request->getPost('original_canonical');
		$count = 0;
		$dem = 0;
		if($originalCanonical != $canonical){
			$count = $this->AutoloadModel->_get_where([
				'select' => 'objectid',
				'table' => 'routers',
				'where' => [
					'canonical' => $canonical
				],
				'count' => TRUE
			]);
			if($count == 0){
				$dem = $this->AutoloadModel->_get_where([
					'select' => 'objectid',
					'table' => 'routers',
					'where' => ['canonical' => $canonical],
					'count' => TRUE
				]);
			}
		}
		if($count > 0 || $dem > 0){
			return false;
		}
		return true;
 	}


}
