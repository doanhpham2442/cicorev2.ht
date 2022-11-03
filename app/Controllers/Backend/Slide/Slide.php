<?php
namespace App\Controllers\Backend\Slide;
use App\Controllers\BaseController;


class Slide extends BaseController{

   protected $slideService;
   protected $authentication;
   protected $language;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'slides';
      $this->slideService = service('SlideService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->slideRepository = service('SlideRepository', $this->module);
	}
	public function index($page = 1){
      if(!$this->authentication->gate('backend.slide.slide.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $slide = $this->slideService->paginate($page);
      $module = $this->module;
      $template = route('backend.slide.slide.index');
      return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'slide', 'module'
         )
      );
	}
	public function create(){
      if(!$this->authentication->gate('backend.slide.slide.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->slideService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
            }else{
              $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
              return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      $method = 'create';
      $title = 'Thêm Mới slide';
      $template = route('backend.slide.slide.store');
      return view(route('backend.dashboard.layout.home'),
       compact('method', 'validate', 'template', 'title')
      );
	}
	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.slide.slide.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $slide = $this->slideRepository->findByField($id, 'tb1.id', $this->language);
      if(!isset($slide) || is_array($slide) == false || count($slide) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
      }

      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->slideService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }
      $method = 'update';
      $title = 'Cập nhật Slide';
      $template = route('backend.slide.slide.store');
      return view(route('backend.dashboard.layout.home'), compact(
         'dropdown', 'method', 'validate', 'template', 'title', 'slide'
         )
      );
	}

   public function delete($id){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.slide.slide.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $slide = $this->slideRepository->findByField($id, 'tb1.id', $this->language);
      if(!isset($slide) || is_array($slide) == false || count($slide) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
      }

      if($this->request->getPost('delete')){
         if($this->slideService->delete($id)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Xóa bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.slide.slide.index'));
         }
      }
      $module = 'delete';
      $template = route('backend.slide.slide.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'slide', 'module')
      );
   }


	private function validation(){
		$validate = [
			'title'   => 'required',
			'keyword' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào tên cho nhóm Slide'
			],
			'keyword' => [
				'required' => 'Bạn phải nhập vào từ khóa cho nhóm Slide'
			]
		];
		return [
			'validate'      => $validate,
			'errorValidate' => $errorValidate,
		];
	}


}
