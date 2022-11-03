<?php
namespace App\Controllers\Backend\Order;
use App\Controllers\BaseController;

class Order extends BaseController{
   protected $orderService;
   protected $authentication;
   protected $orderRepository;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'orders';
      $this->orderService = service('OrderService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->orderRepository = service('OrderRepository', $this->module);
	}

	public function index($page = 1){

      if(!$this->authentication->gate('backend.order.order.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$order = $this->orderService->paginate($page);
      $module = $this->module;
      $template = route('backend.order.order.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'order', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.order.order.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->orderService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.order.order.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.order.order.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      $method = 'create';
      $title = 'Thêm Mớ ngôn ngữ';
      $template = route('backend.order.order.store');
      return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.order.order.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $order = $this->orderRepository->findByField($id, 'tb1.id');
		if(!isset($order) || is_array($order) == false || count($order) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.order.order.index'));
		}
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->orderService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.order.order.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.order.order.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Ngôn ngữ';
      $template = route('backend.order.order.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'order')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.order.order.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $order = $this->orderRepository->findByField($id, 'tb1.id');

		if(!isset($order) || is_array($order) == false || count($order) == 0){
			$this->session->setFlashdata('message-danger', 'Ngôn ngữ không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.order.order.index'));
		}

		if($this->request->getPost('delete')){
         if($this->orderService->delete($id, $order)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.order.order.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.order.order.index'));
         }
		}
      $template = route('backend.order.order.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'order')
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
