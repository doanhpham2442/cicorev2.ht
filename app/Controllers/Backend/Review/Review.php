<?php
namespace App\Controllers\Backend\Review;
use App\Controllers\BaseController;

class Review extends BaseController{
   protected $reviewService;
   protected $authentication;
   protected $reviewRepository;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'product_reviews';
      $this->reviewService = service('ReviewService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->reviewRepository = service('ReviewRepository', $this->module);
	}

	public function index($page = 1){

      if(!$this->authentication->gate('backend.review.review.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$review = $this->reviewService->paginate($page);
      $module = $this->module;
      $template = route('backend.review.review.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'review', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.review.review.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->reviewService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.review.review.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.review.review.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      $method = 'create';
      $title = 'Thêm Mớ ngôn ngữ';
      $template = route('backend.review.review.store');
      return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.review.review.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $review = $this->reviewRepository->findByField($id, 'tb1.id');
		if(!isset($review) || is_array($review) == false || count($review) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.review.review.index'));
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->reviewService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.review.review.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.review.review.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Ngôn ngữ';
      $template = route('backend.review.review.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'review')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.review.review.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $review = $this->reviewRepository->findByField($id, 'tb1.id');

		if(!isset($review) || is_array($review) == false || count($review) == 0){
			$this->session->setFlashdata('message-danger', 'Ngôn ngữ không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.review.review.index'));
		}

		if($this->request->getPost('delete')){
         if($this->reviewService->delete($id, $review)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.review.review.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.review.review.index'));
         }
		}
      $template = route('backend.review.review.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'review')
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
