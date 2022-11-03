<?php
namespace App\Controllers\Backend\Article;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
   protected $articleCatalogueService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $articleCatalogueRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'article_catalogues';
      $this->articleCatalogueService = service('ArticleCatalogueService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => $this->module,'language' => $this->language, 'foreignkey' => 'article_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->articleCatalogueRepository = service('ArticleCatalogueRepository', $this->module);
	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.article.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$articleCatalogue = $this->articleCatalogueService->paginate($page);
      $module = $this->module;
      $template = route('backend.article.catalogue.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'articleCatalogue', 'module'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.article.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->articleCatalogueService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $method = 'create';
      $title = 'Thêm Mới Nhóm Bài Viết';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.article.catalogue.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title')
      );
	}

	public function update($id = 0){
		$id = (int)$id;
      if(!$this->authentication->gate('backend.article.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $articleCatalogue = $this->articleCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($articleCatalogue) || is_array($articleCatalogue) == false || count($articleCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->articleCatalogueService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Bài Viết';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.article.catalogue.store');
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'articleCatalogue')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.article.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $articleCatalogue = $this->articleCatalogueRepository->findByField($id, 'tb1.id');

		if(!isset($articleCatalogue) || is_array($articleCatalogue) == false || count($articleCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Nhóm Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->articleCatalogueService->delete($id, $articleCatalogue)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
         }

		}
      $template = route('backend.article.catalogue.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'articleCatalogue')
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
