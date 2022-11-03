<?php
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{
   protected $userService;
   protected $authentication;
   protected $language;
   protected $userRepository;
   protected $userCatalogueRepository;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'users';
      $this->userService = service('UserService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->userRepository = service('UserRepository', $this->module);
      $this->userCatalogueRepository = service('UserCatalogueRepository', 'user_catalogues');
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.user.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $user = $this->userService->paginate($page);
      $userCatalogue = convertArrayByValue('Nhóm Thành Viên', $this->userCatalogueRepository->all('id, title'), 'id', 'title');
      $module = $this->module;
      $template = route('backend.user.user.index');
      return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'user', 'module', 'userCatalogue'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.user.user.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->userService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.user.user.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.user.user.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $method = 'create';
      $title = 'Thêm Mới Nhóm Thành viên';
      $userCatalogue = convertArrayByValue('Nhóm Thành Viên', $this->userCatalogueRepository->all('id, title'), 'id', 'title');
      $template = route('backend.user.user.store');
		return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'userCatalogue')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.user.user.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $user = $this->userRepository->findByField($id, 'tb1.id');
      if(!isset($user) || is_array($user) == false || count($user) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.user.user.index'));
      }

      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->userService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.user.user.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }
      $method = 'update';
      $title = 'Cập nhật Thành viên';
      $userCatalogue = convertArrayByValue('Nhóm Thành Viên', $this->userCatalogueRepository->all('id, title'), 'id', 'title');
      $template = route('backend.user.user.store');
      return view(route('backend.dashboard.layout.home'), compact(
         'dropdown', 'method', 'validate', 'template', 'title', 'userCatalogue', 'user'
         )
      );
	}

	public function delete($id = 0){

      $id = (int)$id;
      if(!$this->authentication->gate('backend.user.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $id = (int)$id;
      $user = $this->userRepository->findByField($id, 'tb1.id');
      if(!isset($user) || is_array($user) == false || count($user) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.user.user.index'));
      }

      if($this->request->getPost('delete')){
         if($this->userService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.user.user.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.user.user.index'));
         }
      }
      $userCatalogue = convertArrayByValue('Nhóm Thành Viên', $this->userCatalogueRepository->all('id, title'), 'id', 'title');
      $template = route('backend.user.user.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'user', 'userCatalogue')
      );
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_exist',
			'user_catalogue_id' => 'is_natural_no_zero',
			'fullname' => 'required',
		];
		$errorValidate = [
			'email' => [
				'check_email_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			'user_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Thành Viên'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}


}
