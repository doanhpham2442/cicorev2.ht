<?php
namespace App\Controllers\Backend\Marketing;
use App\Controllers\BaseController;

class Voucher extends BaseController{
   protected $voucherService;
   protected $authentication;
   protected $language;
   protected $voucherRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'vouchers';
      $this->voucherService = service('VoucherService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->voucherRepository = service('VoucherRepository', $this->module);
      $this->productRepository = service('ProductRepository', 'products');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');

	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.marketing.voucher.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$voucher = $this->voucherService->paginate($page);
      $module = $this->module;
      $template = route('backend.marketing.voucher.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'voucher', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.marketing.voucher.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         $object = [];
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->voucherService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->selectedVoucherObject($id, $module);
         }
		}

      $module = 'voucher';
      $method = 'create';
      $fixWrapper = 'fix-wrapper';
      $title = 'Thêm Mới Mã Khuyến Mãi';
      $template = route('backend.marketing.voucher.store');
		return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'module', 'fixWrapper', 'object')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      $object = [];
      if(!$this->authentication->gate('backend.marketing.voucher.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $voucher = $this->voucherRepository->findByField($id, 'tb1.id');

      $object = $this->selectedVoucherObject(json_decode($voucher['object_id']), $voucher['module']);

		if(!isset($voucher) || is_array($voucher) == false || count($voucher) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.marketing.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();

         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->voucherService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->selectedVoucherObject($id, $module);
         }
		}


      $fixWrapper = 'fix-wrapper';
      $method = 'update';
      $title = 'Cập nhật Mã Khuyến Mãi';
      $template = route('backend.marketing.voucher.store');
      $module = 'voucher';
      return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'voucher', 'module', 'fixWrapper', 'object')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.marketing.voucher.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $voucher = $this->voucherRepository->findByField($id, 'tb1.id');

		if(!isset($voucher) || is_array($voucher) == false || count($voucher) == 0){
			$this->session->setFlashdata('message-danger', 'Mã Khuyến Mãi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.marketing.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->voucherService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.marketing.voucher.index'));
         }
		}
      $template = route('backend.marketing.voucher.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'voucher')
      );
	}

   private function selectedVoucherObject($id, $module){
      $object = [];
      switch ($module) {
         case 'products':
            $object = $this->productRepository->findProductByIdArray($id, $this->language);
            break;
         case 'product_catalogues':
            $object = $this->productCatalogueRepository->findByIdArray($id, $this->language);
            break;
      }

      return $object;
   }

	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router[]',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'voucher_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
