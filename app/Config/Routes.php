<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}
/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */



$routes->get('/','Frontend\Homepage\Home::index');
$routes->get('trang-chu'.HTSUFFIX,'Frontend\Homepage\Home::index');
$routes->match(['get','post'],'gio-hang'.HTSUFFIX, 'Frontend\Cart\Cart::index');
$routes->get('dat-hang-thanh-cong'.HTSUFFIX,'Frontend\Cart\Cart::orderSuccess');

$routes->get('lien-he'.HTSUFFIX,'Frontend\Contact\Contact::index');


$routes->post('thanh-toan'.HTSUFFIX,'Frontend\Cart\Cart::index', ['as' => 'payment']);
$routes->get('thong-tin-don-hang'.HTSUFFIX, 'Frontend\Product\Cart::method');


$routes->get('/admin', 'Backend/Authentication/Auth::login',['filter' => 'login' ]);
$routes->get('([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Homepage\Router::index/$1');
$routes->get('([a-zA-Z0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Homepage\Router::index/$1/$2');

$routes->get(BACKEND_DIRECTORY, 'Backend/Authentication/Auth::login', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/forgot', 'Backend/Authentication/Auth::forgot', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/logout', 'Backend/Authentication/Auth::logout', ['filter' => 'auth' ]);
$routes->match(['get','post'],'backend/dashboard/dashboard/index', 'Backend/Dashboard/Dashboard::index', ['filter' => 'auth']);


$name = [
    'user','user catalogue','article','article catalogue','attribute', 'attribute catalogue','location', 'location catalogue',
    'panel', 'product', 'product catalogue', 'tour', 'tour catalogue','media', 'media catalogue', 'language',
];

/*MENU*/
$routes->group('backend/menu/menu', ['filter' => 'auth'] , function($routes){
    $routes->add('listmenu', 'Backend/Menu/Menu::listmenu');
    $routes->add('createmenu', 'Backend/Menu/Menu::createmenu');
    $routes->add('create', 'Backend/Menu/Menu::create');
});

/*SYSTEM_GENERAL*/
$routes->group('backend/system/general', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/System/General::index');
    $routes->add('translator', 'Backend/System/General::translator');
});

$routes->group('backend/slide/translate/translate', ['filter' => 'auth'] , function($routes){
    $routes->add('translate', 'Backend/Slide/Translate::translate');
});

/*SLIDE*/
$routes->group('backend/slide/slide', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Slide/Slide::index');
    $routes->add('create', 'Backend/Slide/Slide::create');
    $routes->add('update', 'Backend/Slide/Slide::update');
    $routes->add('delete', 'Backend/Slide/Slide::delete');
});


foreach ($name as $key => $value) {
    $convert = ucwords($value);
    $extract_normal = explode(' ', $value);
    $group = ((isset($extract_normal[1]) && $extract_normal[1] != '') ? 'backend/'.$extract_normal[0].'/'.$extract_normal[1] : 'backend/'.$extract_normal[0].'/'.$extract_normal[0]);
    $extract_convert = explode(' ', $convert);
    $router = ((isset($extract_convert[1]) && $extract_convert[1] != '') ? 'Backend/'.$extract_convert[0].'/'.$extract_convert[1] : 'Backend/'.$extract_convert[0].'/'.$extract_convert[0]);

    $routes->router = $router;

    $routes->group($group, ['filter' => 'auth'], function($routes){

        $routes->add('index',  $routes->router.'::index');
        $routes->add('create',  $routes->router.'::create');
        $routes->add('update',  $routes->router.'::update');
        $routes->add('delete',  $routes->router.'::delete');
    });
}


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
