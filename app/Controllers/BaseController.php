<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\AutoloadModel;
use App\Libraries\Authentication;
use App\Libraries\Pagination;
use App\Libraries\Mobile_Detect;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form','url','myauthentication','mystring','mydata','nestedtset', 'myurl', 'myinsert','mypagination'];
	public $request;
   public $session;
   public $AutoloadModel;
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
      $this->AutoloadModel = new \App\Models\AutoloadModel();
		helper($this->helpers);
	}

	public function currentLanguage(){
		$language = 2;
		if(!isset($_COOKIE['BACKEND_language']) || $_COOKIE['BACKEND_language'] == ''){
			setcookie('BACKEND_language', $language , time() + 1*24*3600, "/");
		}else{
			$language = $_COOKIE['BACKEND_language'];
		}
		return $language;
	}


}
