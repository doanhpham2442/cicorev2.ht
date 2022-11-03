<?php
namespace App\Controllers\Backend\Attribute;
use App\Controllers\BaseController;

class Attribute extends BaseController{
   protected $attributeService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $attributeRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'attributes';
      $this->attributeService = service('AttributeService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'attribute_catalogues', 'language' => $this->language, 'foreignkey' => 'attribute_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->attributeRepository = service('attributeRepository', $this->module);

	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.attribute.attribute.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$attribute = $this->attributeService->paginate($page);
      $dropdown = $this->nestedsetbie->dropdown();
      $module = $this->module;
      $template = route('backend.attribute.attribute.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'attribute', 'module', 'dropdown'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.attribute.attribute.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->attributeService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $module = 'attribute';
      $method = 'create';
      $title = 'Thêm Mới Thuộc Tính';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.attribute.attribute.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'module')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.attribute.attribute.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $attribute = $this->attributeRepository->findByField($id, 'tb1.id');

		if(!isset($attribute) || is_array($attribute) == false || count($attribute) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->attributeService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Thuộc Tính';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.attribute.attribute.store');
      $module = 'attribute';
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'attribute', 'module')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.attribute.attribute.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $attribute = $this->attributeRepository->findByField($id, 'tb1.id');

		if(!isset($attribute) || is_array($attribute) == false || count($attribute) == 0){
			$this->session->setFlashdata('message-danger', 'Thuộc Tính không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.attribute.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->attributeService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.attribute.attribute.index'));
         }
		}
      $template = route('backend.attribute.attribute.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'attribute')
      );
	}
	private function validation(){
		$validate = [
			'title' => 'required',
			'attribute_catalogue_id' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'attribute_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
