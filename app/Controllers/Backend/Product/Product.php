<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Product extends BaseController{
   protected $productService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $productRepository;
   protected $attributeCatalogueRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'products';
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'product_catalogues', 'language' => $this->language, 'foreignkey' => 'product_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->productRepository = service('productRepository', $this->module);
      $this->attributeCatalogueRepository = service('AttributeCatalogueRepository', 'attribute_catalogues');

	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.product.product.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$product = $this->productService->paginate($page);
      $dropdown = $this->nestedsetbie->dropdown();
      $module = $this->module;
      $template = route('backend.product.product.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'product', 'module', 'dropdown'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.product.product.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
      dd($_POST);
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.product.product.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.product.product.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $module = 'product';
      $method = 'create';
      $title = 'Thêm Mới Sản Phẩm';
      $dropdown = $this->nestedsetbie->dropdown();
      $attributeCatalogue = $this->attributeCatalogueRepository->findAll();
      $template = route('backend.product.product.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'module', 'attributeCatalogue')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.product.product.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $product = $this->productRepository->findByField($id, 'tb1.id');

		if(!isset($product) || is_array($product) == false || count($product) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.product.product.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.product.product.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Sản Phẩm';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.product.product.store');
      $module = 'product';
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'product', 'module')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.product.product.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $product = $this->productRepository->findByField($id, 'tb1.id');

		if(!isset($product) || is_array($product) == false || count($product) == 0){
			$this->session->setFlashdata('message-danger', 'Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.product.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->productService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.product.product.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.product.product.index'));
         }
		}
      $template = route('backend.product.product.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'product')
      );
	}
	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router[]',
			'product_catalogue_id' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'product_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
