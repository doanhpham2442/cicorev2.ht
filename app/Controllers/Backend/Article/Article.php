<?php
namespace App\Controllers\Backend\Article;
use App\Controllers\BaseController;

class Article extends BaseController{
   protected $articleService;
   protected $nestedsetbie;
   protected $authentication;
   protected $language;
   protected $articleRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->module = 'articles';
      $this->articleService = service('ArticleService',
         ['language' => $this->language, 'module' => $this->module]
      );
      $this->nestedsetbie = service('Nestedsetbie',
         ['table' => 'article_catalogues', 'language' => $this->language, 'foreignkey' => 'article_catalogue_id']
      );
      $this->authentication = service('Auth');
      $this->articleRepository = service('articleRepository', $this->module);

	}

	public function index($page = 1){
      if(!$this->authentication->gate('backend.article.article.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$article = $this->articleService->paginate($page);
      $dropdown = $this->nestedsetbie->dropdown();
      $module = $this->module;
      $template = route('backend.article.article.index');
		return view(route('backend.dashboard.layout.home'),
         compact(
            'template', 'article', 'module', 'dropdown'
         )
      );
	}

	public function create(){
      if(!$this->authentication->gate('backend.article.article.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->articleService->create()){
               $this->session->setFlashdata('message-success', 'Thêm mới bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.article.article.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Thêm mới bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.article.article.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}

      $module = 'article';
      $method = 'create';
      $title = 'Thêm Mới Bài Viết';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.article.article.store');
		return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'module')
      );
	}

	public function update($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.article.article.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
      $article = $this->articleRepository->findByField($id, 'tb1.id');

		if(!isset($article) || is_array($article) == false || count($article) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->articleService->update($id)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
               return redirect()->to(BASE_URL.route('backend.article.article.index'));
            }else{
               $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
               return redirect()->to(BASE_URL.route('backend.article.article.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $method = 'update';
      $title = 'Cập nhật Nhóm Bài Viết';
      $dropdown = $this->nestedsetbie->dropdown();
      $template = route('backend.article.article.store');
      $module = 'article';
      return view(route('backend.dashboard.layout.home'),
         compact('dropdown', 'method', 'validate', 'template', 'title', 'article', 'module')
      );
	}

	public function delete($id = 0){
      $id = (int)$id;
      if(!$this->authentication->gate('backend.article.article.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.route('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $article = $this->articleRepository->findByField($id, 'tb1.id');

		if(!isset($article) || is_array($article) == false || count($article) == 0){
			$this->session->setFlashdata('message-danger', 'Bài Viết không tồn tại');
 			return redirect()->to(BASE_URL.route('backend.article.catalogue.index'));
		}

		if($this->request->getPost('delete')){
         if($this->articleService->delete($id)){
            $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công!');
            return redirect()->to(BASE_URL.route('backend.article.article.index'));
         }else{
            $this->session->setFlashdata('message-danger', 'Cập nhật bản ghi không thành công!');
            return redirect()->to(BASE_URL.route('backend.article.article.index'));
         }
		}
      $template = route('backend.article.article.delete');
      return view(route('backend.dashboard.layout.home'),
         compact('template', 'article')
      );
	}
	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router[]',
			'article_catalogue_id' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'article_catalogue_id' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài viết',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
