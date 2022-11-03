<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('BACKEND_DIRECTORY', 'admin');

define('AUTH', 'HTVIETNAM_');
define('ASSET_BACKEND', 'public/backend/');

define('BASE_URL', 'http://cicorev2.com/');
define('HTSUFFIX', '.html');

define('ADDRESS', 0);

define('DEBUG', 0);
define('COMPRESS', 0);
define('CMS_NAME', 'HT VIETNAM CMS 3.0');
define('API_WIDGET', 'http://widget.htweb.vn');

define('HTSEARCH', 'tim-kiem');
define('HTCONTACT', 'contact-us');
define('HTMAP', 'contact-map');

define('HTDBHOST', 'localhost');
define('HTDBUSER', 'root');
define('HTDBPASS', 'root');
define('HTDBNAME', 'project');




const VOUCHER_TYPE = [
   'bill' => [
      'name' => 'bill',
      'icon' => '<i class="fa fa-shopping-cart" aria-hidden="true"></i>',
      'title' => 'Giảm giá đơn hàng'
   ],
   'money' => [
      'name' => 'money',
      'icon' => '<i class="fa fa-product-hunt" aria-hidden="true"></i>',
      'title' => 'Giảm giá sản phẩm'
   ],
   'same' => [
      'name' => 'same',
      'icon' => '<i class="fa fa-money" aria-hidden="true"></i>',
      'title' => 'Đồng Giá'
   ],
   'ship' => [
      'name' => 'ship',
      'icon' => '<i class="fa fa-truck" aria-hidden="true"></i>',
      'title' => 'Giảm giá vận chuyển'
   ],

];
