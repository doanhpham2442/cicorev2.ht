<?php
namespace App\Controllers\Backend\Attribute;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
   protected $attributeCatalogueService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $attributeCatalogueRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'attribute_catalogues';
      $this->attributeCatalogueService = service('AttributeCatalogueService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => $this->module,'language' => $this->language, 'foreignkey' => 'attribute_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->attributeCatalogueRepository = service('AttributeCatalogueRepository', $this->module);
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.attribute.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$attributeCatalogue = $this->attributeCatalogueService->paginate($page);
      $module = $this->module;
      $template = route('backend.attribute.catalogue.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'attributeCatalogue', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.attribute.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->attributeCatalogueService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $method = 'create';
      $title = 'Thêm Mới Nhóm Thuộc Tính';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.attribute.catalogue.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
		$id = (int)$id;
      if(!$this->authentication->gate('backend.attribute.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $attributeCatalogue = $this->attributeCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($attributeCatalogue) || is_array($attributeCatalogue) == false || count($attributeCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->attributeCatalogueService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Thuộc Tính';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.attribute.catalogue.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'attributeCatalogue')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.attribute.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $attributeCatalogue = $this->attributeCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($attributeCatalogue) || is_array($attributeCatalogue) == false || count($attributeCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Nhóm Thuộc Tính không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->attributeCatalogueService->delete($id, $attributeCatalogue)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
         }

		}
      $template = route('backend.attribute.catalogue.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'attributeCatalogue')
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
