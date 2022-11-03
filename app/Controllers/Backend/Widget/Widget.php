<?php
namespace App\Controllers\Backend\Widget;
use App\Controllers\BaseController;

class Widget extends BaseController{
   protected $widgetService;
   protected $authentication;
   protected $language;
   protected $widgetRepository;
   protected $moduleList = [
      'articles' => 'Bài Viết',
      'article_catalogues' => 'Danh Mục Bài Viết',
      'products' => 'Sản phẩm',
      'product_catalogues' => 'Danh Mục Sản phẩm',
   ];
   protected $productRepository;
   protected $productCatalogueRepository;
   protected $articleCatalogueRepository;
   protected $articleRepository;
   protected $widget;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'widgets';
      $this->widgetService = service('WidgetService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->authentication = service('Auth');
      $this->widgetRepository = service('WidgetRepository', $this->module);
      $this->productRepository = service('productRepository', 'products');
      $this->articleRepository = service('articleRepository', 'articles');
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', 'article_catalogues');
      $this->widget = service('widget', ['language' => $this->language]);
	}

	public function index($page = 1){

      if(!$this->authentication->gate('backend.widget.widget.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $widget = $this->widgetService->paginate($page);
      $module = $this->module;
      $template = route('backend.widget.widget.index');
      return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'widget', 'module', 'widgetCatalogue'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.widget.widget.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->widgetService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->widget->findObjectByModule($id, $module, $this->language);
         }
		}

      $fixWrapper = 'fix-wrapper';
      $module = 'widget';
      $method = 'create';
      $title = 'Thêm Mới Widget';
      $moduleList = $this->moduleList;
      $template = route('backend.widget.widget.store');
		return view(route('backend.dashboard.layout.home'),
         compact('method', 'validate', 'template', 'title', 'moduleList', 'module', 'fixWrapper', 'object')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.widget.widget.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $widget = $this->widgetRepository->findByField($id, 'tb1.id');
      if(!isset($widget) || is_array($widget) == false || count($widget) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
      }

      $object = $this->widget->findObjectByModule(json_decode($widget['object_id']), $widget['module'], $this->language);

      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->widgetService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
            $id = $this->request->getPost('object_id');
            $module = $this->request->getPost('module');
            $object = $this->widget->findObjectByModule($id, $module, $this->language);
         }
      }
      $fixWrapper = 'fix-wrapper';
      $module = 'widget';
      $method = 'update';
      $title = 'Cập nhật Widget';
      $moduleList = $this->moduleList;
      $template = route('backend.widget.widget.store');
      return view(route('backend.dashboard.layout.home'), compact(
            'dropdown', 'method', 'validate', 'template', 'title',  'widget', 'moduleList','module', 'fixWrapper', 'object'
         )
      );
	}

	public function delete($id = 0){

      $id = (int)$id;
      if(!$this->authentication->gate('backend.widget.widget.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $id = (int)$id;
      $widget = $this->widgetRepository->findByField($id, 'tb1.id');
      if(!isset($widget) || is_array($widget) == false || count($widget) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
      }

      if($this->request->getPost('delete')){
         if($this->widgetService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.widget.widget.index'));
         }
      }
      $template = route('backend.widget.widget.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'widget')
      );
	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'module' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào tiêu đề!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}


}
