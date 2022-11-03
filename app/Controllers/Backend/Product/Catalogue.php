<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
   protected $productCatalogueService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $productCatalogueRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'product_catalogues';
      $this->productCatalogueService = service('ProductCatalogueService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => $this->module,'language' => $this->language, 'foreignkey' => 'product_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', $this->module);
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.product.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$productCatalogue = $this->productCatalogueService->paginate($page);
      $module = $this->module;
      $template = route('backend.product.catalogue.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'productCatalogue', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.product.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }


		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productCatalogueService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $method = 'create';
      $title = 'Thêm Mới Nhóm Sản Phẩm';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.product.catalogue.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
		$id = (int)$id;
      if(!$this->authentication->gate('backend.product.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $productCatalogue = $this->productCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($productCatalogue) || is_array($productCatalogue) == false || count($productCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productCatalogueService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Sản Phẩm';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.product.catalogue.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'productCatalogue')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.product.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $productCatalogue = $this->productCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($productCatalogue) || is_array($productCatalogue) == false || count($productCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Nhóm Sản Phẩm không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->productCatalogueService->delete($id, $productCatalogue)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
         }
		}
      $template = route('backend.product.catalogue.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'productCatalogue')
      );
	}


	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router['.$this->module.']',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
