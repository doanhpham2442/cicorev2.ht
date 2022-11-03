<?php
namespace App\Controllers\Frontend;
use App\Controllers\FrontendController;
use App\Libraries\Blade;

class Test extends FrontendController{

   protected $blade;
   protected $url;

	public function __construct(){

      $this->url = substr(APPPATH, 0, -1);




	}

	public function index(){


      $views = $this->url . '/Views';
      $cache = $this->url . '/cache';

      $blade = new \App\Libraries\Blade($views); // MODE_DEBUG allows to pinpoint troubles.
      echo $blade->run("hello",array("variable1"=>"value1")); // it calls /views/hello.blade.php
	}


}
