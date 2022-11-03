<?php
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
   protected $userCatalogueService;
   protected $authentication;
   protected $language;
   protected $userCatalogueRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'user_catalogues';
      $this->userCatalogueService = service('UserCatalogueService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->userCatalogueRepository = service('UserCatalogueRepository', $this->module);
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.user.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $userCatalogue = $this->userCatalogueService->paginate($page);
      $module = $this->module;
      $template = route('backend.user.catalogue.index');
      return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'userCatalogue', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.user.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->userCatalogueService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $method = 'create';
      $title = 'Thêm Mới Nhóm Thành viên';
      $template = route('backend.user.catalogue.store');
		return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.user.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $userCatalogue = $this->userCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($userCatalogue) || is_array($userCatalogue) == false || count($userCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->userCatalogueService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Thành viên';
      $template = route('backend.user.catalogue.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'userCatalogue')
      );
	}

	public function delete($id = 0){

      $id = (int)$id;
      if(!$this->authentication->gate('backend.user.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $id = (int)$id;
      $userCatalogue = $this->userCatalogueRepository->findByField($id, 'tb1.id');
      if(!isset($userCatalogue) || is_array($userCatalogue) == false || count($userCatalogue) == 0){
         $this->session->setFlashdata('message-danger', 'Nhóm Thành viên không tồn tại');
         return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
      }

      if($this->request->getPost('delete')){
         if($this->userCatalogueService->delete($id, $userCatalogue)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.user.catalogue.index'));
         }
      }
      $template = route('backend.user.catalogue.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'userCatalogue')
      );
	}

   private function validation(){
      $validate = [
         'title' => 'required',
      ];
      $errorValidate = [
         'title' => [
            'required' => 'Bạn phải nhập vào trường tiêu đề'
         ],
      ];
      return [
         'validate' => $validate,
         'errorValidate' => $errorValidate,
      ];
   }

}
