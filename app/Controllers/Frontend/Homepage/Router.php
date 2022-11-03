<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;


class Router extends FrontendController{

   protected $routerRepository;

   public function __construct(){
      $this->routerRepository = service('routerRepository','routers');

   }

	public function index($canonical = '', $page = 1){
        $router = $this->routerRepository->findByField($canonical, 'canonical');
        if(isset($router) && is_array($router) && count($router)){
             return view_cell($router['view'], 'id='.$router['objectid'].', page='.$page.'');
        }else{
            return redirect()->to('notfound');
        }
	}
}
