<?php
namespace App\Controllers\Backend\Language;
use App\Controllers\BaseController;

class Language extends BaseController{
   protected $languageService;
   protected $authentication;
   protected $languageRepository;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'languages';
      $this->languageService = service('LanguageService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->languageRepository = service('LanguageRepository', $this->module);
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.language.language.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$language = $this->languageService->paginate($page);
      $module = $this->module;
      $template = route('backend.language.language.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'language', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.language.language.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->languageService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.language.language.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.language.language.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      $method = 'create';
      $title = 'Thêm Mớ ngôn ngữ';
      $template = route('backend.language.language.store');
      return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.language.language.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $language = $this->languageRepository->findByField($id, 'tb1.id');
		if(!isset($language) || is_array($language) == false || count($language) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.language.language.index'));
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->languageService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.language.language.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.language.language.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Ngôn ngữ';
      $template = route('backend.language.language.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'language')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.language.language.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $language = $this->languageRepository->findByField($id, 'tb1.id');

		if(!isset($language) || is_array($language) == false || count($language) == 0){
			$this->session->setFlashdata('message-danger', 'Ngôn ngữ không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.language.language.index'));
		}

		if($this->request->getPost('delete')){
         if($this->languageService->delete($id, $language)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.language.language.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.language.language.index'));
         }
		}
      $template = route('backend.language.language.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'language')
      );
	}



	private function validation(){
		$validate = [
			'title' => 'required',
			// 'canonical' => 'required|check_canonical['.$this->data['module'].']'
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập vào trường từ khóa',
				'check_canonical' => 'Ngôn ngữ đã tồn tại'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
