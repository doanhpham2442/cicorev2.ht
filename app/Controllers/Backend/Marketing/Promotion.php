<?php
namespace App\Controllers\Backend\Marketing;
use App\Controllers\BaseController;

class Promotion extends BaseController{
   protected $promotionService;
   protected $authentication;
   protected $language;
   protected $promotionRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'promotions';
      $this->promotionService = service('PromotionService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->promotionRepository = service('promotionRepository', $this->module);
      $this->productRepository = service('ProductRepository', 'products');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');

	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.marketing.promotion.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$promotion = $this->promotionService->paginate($page);
      $module = $this->module;
      $template = route('backend.marketing.promotion.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'promotion', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.marketing.promotion.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         $object = [];
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->promotionService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->selectedPromotionObject($id, $module);
         }
		}

      $module = 'promotion';
      $method = 'create';
      $fixWrapper = 'fix-wrapper';
      $title = 'Thêm Mới Chương Trình Khuyến Mãi';
      $template = route('backend.marketing.promotion.store');
		return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'module', 'fixWrapper', 'object')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      $object = [];
      if(!$this->authentication->gate('backend.marketing.promotion.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $promotion = $this->promotionRepository->findByField($id, 'tb1.id');

      $object = $this->selectedPromotionObject(json_decode($promotion['object_id']), $promotion['module']);

		if(!isset($promotion) || is_array($promotion) == false || count($promotion) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.marketing.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();

         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->promotionService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->selectedPromotionObject($id, $module);
         }
		}


      $fixWrapper = 'fix-wrapper';
      $method = 'update';
      $title = 'Cập nhật Chương Trình Khuyến Mãi';
      $template = route('backend.marketing.promotion.store');
      $module = 'promotion';
      return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'promotion', 'module', 'fixWrapper', 'object')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.marketing.promotion.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $promotion = $this->promotionRepository->findByField($id, 'tb1.id');

		if(!isset($promotion) || is_array($promotion) == false || count($promotion) == 0){
			$this->session->setFlashdata('message-danger', 'Chương Trình Khuyến Mãi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.marketing.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->promotionService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.marketing.promotion.index'));
         }
		}
      $template = route('backend.marketing.promotion.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'promotion')
      );
	}

   private function selectedPromotionObject($id, $module){
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
			'promotion_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
