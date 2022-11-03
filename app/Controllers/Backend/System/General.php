<?php
namespace App\Controllers\Backend\System;
use App\Controllers\BaseController;
use App\Controllers\Backend\System\Libraries\Configbie;

class General extends BaseController{
	protected $data;
	public $configbie;

   protected $systemService;
   protected $systemRepository;
   protected $authentication;
   protected $language;


	public function __construct(){
		$this->configbie = new ConfigBie();
      $this->language = $this->currentLanguage();
      $this->module = 'systems';
      $this->systemService = service('SystemService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->systemRepository = service('systemRepository', $this->module);

	}


	public function index($page = 1){
      if(!$this->authentication->gate('backend.system.general.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }

		$systemList = $this->configbie->system();
		$system = $this->systemRepository->all();
		$temp = [];
		if(isset($system) && is_array($system) && count($system)){
			foreach($system as $key => $val){
				$temp[$val['keyword']] = $val['content'];
			}
		}


      if($this->request->getMethod() == 'post'){
         if($this->systemService->execute()){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.system.general.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.system.general.index'));
         }
		}

		if($this->request->getMethod() == 'post'){

			$config  = $this->request->getPost('config');
			if(isset($config) && is_array($config) && count($config)){
				// $delete = $this->AutoloadModel->_delete([
				// 	'table' => 'system_translate',
				// 	'where' => ['language' => $this->currentLanguage()]
				// ]);
				$_update = [];
				foreach($config as $key => $val){
					$_update[] = [
						'language' => $this->currentLanguage(),
						'keyword' => $key,
						'content' => $val,
					];

				}

            pre($_update);die();
				$flag =	$this->AutoloadModel->_create_batch([
					'table' => 'system_translate',
					'data' => $_update,
				]);
			}
	 		if($flag > 0){

	 			$session->setFlashdata('message-success', 'Cập Nhật Cấu hình chung Thành Công!');
				return redirect()->to(BASE_URL.'backend/system/general/index');
	 		}
		}

      $template = route('backend.system.general.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'temp', 'systemList'
         )
      );
	}
}
