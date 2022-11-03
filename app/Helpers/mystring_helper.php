<?php
/* NEWS HELPER */

if(!function_exists('paymentMethod')){
   function paymentMethod(){
      $paymentMethod = [
         0 => [
            'method' => 'COD',
            'img' => 'public/frontend/resources/img/COD.svg',
            'name' => 'COD ( Thanh toán khi nhận hàng )'
         ],
         1 => [
            'method' => 'Zalo',
            'img' => 'public/frontend/resources/img/logo-zalopay.svg',
            'name' => 'Ví điện tử ZaloPay'
         ],
         2 => [
            'method' => 'Shopee',
            'img' => 'public/frontend/resources/img/momo-icon.webp',
            'name' => 'Ví ShopeePay <br> <i>Giảm thêm 50k cho khách hàng lần đầu mở ví và thanh toán bằng ShopeePay</i>'
         ],
         3 => [
            'method' => 'ATM',
            'img' => 'public/frontend/resources/img/195dbf69c0ac36f26fbd_(1).webp',
            'name' => 'Thẻ ATM / Internet Banking <br>Thẻ tín dụng (Credit card) / Thẻ ghi nợ (Debit card) <br>VNPay QR'
         ],
         4 => [
            'method' => 'Vnpay',
            'img' => 'public/frontend/resources/img/vnpay.webp',
            'name' => 'Ví điện tử VNPay'
         ],
      ];

      return $paymentMethod;
   }
}

if(!function_exists('GetSerialCode')){
   function GetSerialCode() {
         $strings = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
         $stringLength = strlen($strings);
         $newStrings = '';
         for ($i = 0; $i < 8; $i++) {
              $newStrings .= $strings[rand(0, $stringLength - 1)];
         }
         return $newStrings;
      }
}




if(!function_exists('converProvinceArray')){
   function converProvinceArray(array $array){
      $newArray = [];
      $newArray[0] = 'Chọn Thành Phố';
      if(isset($array) && is_array($array) && count($array)){
         foreach($array as $key => $val){
            $newArray[$val['provinceid']] = $val['name'];
         }
      }
      return $newArray;
   }
}

if(!function_exists('commas')){
	function commas($number){
	     return number_format($number, 0,',','.');
	}
}


if(!function_exists('seo')){
	function seo($object, $canonical, $type){
	     return [
          'meta_title' => (!empty($object['meta_title'])) ? $object['meta_title'] : $object['title'],
          'meta_description' => (!empty($object['meta_description'])) ? $object['meta_description'] : cutnchar(strip_tags(htmlspecialchars_decode(html_entity_decode($object['description']))), 300),
          'meta_image' => (isset($object['image'])) ?? '',
          'oh_type' => $type,
          'canonical' => $canonical,
       ];
	}
}


if(!function_exists('route')){
	function route($string = ''){
	     return str_replace('.', '/' , $string);

	}
}



if(!function_exists('currentTime')){
	function currentTime(){
	     return gmdate('Y-m-d H:i:s', time() + 7*3600);
	}
}


if (! function_exists('validate_input')){
	function validate_input(string $string): string{
		return htmlspecialchars_decode(html_entity_decode($string));
	}
}


if (!function_exists('request')) {
    function request()
    {
        $request = \Config\Services::request();
        return $request;
    }
}

if (!function_exists('requestAccept')) {
   function requestAccept($accept = [], $userId = 0)
   {
      $request = \Config\Services::request();
      $post = $request->getPost();
      if($post && count($accept) > 0){
         foreach($post as $key => $val){
            if(!in_array($key, $accept))
               unset($post[$key]);
         }
      }
      if(isset($userId) && $userId > 0 ){
         $post['created_at'] = currentTime();
         $post['updated_at'] = currentTime();
         $post['userid_created'] = $userId;
         $post['userid_updated'] = $userId;
      }
      if(isset($post['album'])){
         $post['album'] = json_encode($post['album']);
      }
      if(isset($post['original_canonical'])){
         unset($post['original_canonical']);
      }
      return $post;
   }
}

if (!function_exists('requestExcerpt')) {
   function requestExcerpt($excerpt = [], $userId = 0)
   {
      $request = \Config\Services::request();
      $post = $request->getPost();
      if($post && count($excerpt) > 0){
         foreach($post as $key => $val){
            if(in_array($key, $excerpt))
               unset($post[$key]);
         }
      }
      if(isset($userId) && $userId > 0 ){
         $post['created_at'] = currentTime();
         $post['updated_at'] = currentTime();
         $post['userid_created'] = $userId;
         $post['userid_updated'] = $userId;
      }
      if(isset($post['album'])){
         $post['album'] = json_encode($post['album']);
      }
      return $post;
   }
}

if (!function_exists('routerParam')) {
    function router($segment_1, $segment_2, $id, $module, $language, $canonical)
    {
      $uri = '\App\Controllers\Frontend\\'.$segment_1.'\\'.$segment_2.'::index';
      $router = [
         'objectid' => $id,
         'language' => $language,
         'module' => $module,
         'view' => $uri,
         'canonical' => $canonical
      ];
      return $router;
    }
}

if(!function_exists('getPrice')){
	function getPrice($product = [], $promotion = []){

      if($product['price'] == 0){
         return [
            'priceString' => 'Liên Hệ',
            'priceSaleString' => 0,
            'percent' => 0,
            'price' => 0,
            'priceSale' => 0,
         ];
      }

      $priceNew = $product['price'];
      $priceSale = 0;
      $saleValue = 0;
      if(isset($promotion) && is_array($promotion) && count($promotion)){
         foreach($promotion as $key => $val){
            if($val['type'] == 'same'){
               $priceSale = $val['discount_value'];
            }else if($val['type'] == 'money'){
               if($val['discount_type'] == 'money'){
                  $saleValue = $saleValue + $val['discount_value'];
               }
               if($val['discount_type'] == 'percent'){
                  $saleValue = $saleValue + (($priceNew*$val['discount_value'])/100);
               }
            }
         }
      }

      $priceSale = $priceNew - $saleValue;

      if($product['price_sale'] > 0){
         $priceSale = $product['price_sale'];
      }

      return [
         'priceString' => number_format($priceNew, 0, ',', '.').' đ',
         'priceSaleString' => number_format($priceSale, 0, ',', '.').' đ',
         'percent' => percent($priceNew, $priceSale),
         'price' => $priceNew,
         'priceSale' => $priceSale,
      ];

	}
}

if(!function_exists('getStock')){
	function getStock(){

      return ( 1 == 1) ? 'CÒN HÀNG' : 'HẾT HÀNG';


	}
}


if(!function_exists('getReview')){
	function getReview($totalReview, $totalRate, $maxRate = 5){

      $averate = 0;
      $percent = 0;
      if($totalReview > 0){
         $averate = $totalRate/$totalReview;
         $percent = $averate/$maxRate;
      }

      // echo $averate;

      return [
         'averate' => $averate,
         'percent' => $percent*100,
         'totalReview' => $totalReview
      ];

	}
}

if(!function_exists('renderReviewBlock')){
	function renderReviewBlock($review){


      return '<div class="product-rating">
         <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
              <span style="width: '.$review['percent'].'%;">Rated <strong class="rating">'.$review['averate'].'</strong> out of 5</span>
         </div>
         <div class="count-rating"> Đánh giá: '.$review['totalReview'].' <span class="rating-text">Ratings</span></div>
      </div>';


	}
}

if(!function_exists('changeDateFormat')){

   function changeDateFormat($originalDate, $format = 'd-m-Y'){
      return date($format, strtotime($originalDate));
   }

}


/* -- -- */

if(!function_exists('price')){
	function price($price = 0, $price_sale = 0){
		$finalPrice = ($price_sale > 0) ? $price_sale : $price;
		return [
			'finalPrice' =>$finalPrice,
			'flag' => ($price_sale > 0) ? TRUE : FALSE
		];

	}
}

if(!function_exists('percent')){
	function percent($price = 0, $saleoff = 0){
		if($price == 0){
			$percent = 0;
		}else{
			$percent = ($price - $saleoff)/$price*100;
		}
		return round($percent);
	}
}

if(!function_exists('makeCartOption')){
	function makeCartOption(){
		return [];
	}
}

if(!function_exists('start_and_date_of_month')){
	function start_and_date_of_month($date){
		$param['start'] = date('Y-m-01', strtotime($date));
		$param['end'] = date('Y-m-t', strtotime($date));
		return $param;
	}
}

if(!function_exists('month_number_ago')){
	function month_number_ago($limit = 0,$param = []){
		if($limit < 0) return $param;
		$date = new DateTime(); //Today
		$modify = '-'.$limit.' months';
		$dateMinus12 = $date->modify($modify); // Last day 12 months ago
		$new_date = $dateMinus12->format('Y-m-d');
		$result = start_and_date_of_month($new_date);
		$in_month = $dateMinus12->format('M');
		$result['month'] = $in_month;
		$param[] = $result;
		return month_number_ago($limit - 1, $param);
	}
}

if(!function_exists('translate')){
	function translate(string $string = '', string $language = '', array $param = []){

		if(in_array($language, ['vi','en']) == false){
			$language = 'en';
		}

		return lang($string, $param, $language);
	}
}

if(!function_exists('check_array')){
	function check_array(array $param = []){
		if(isset($param) && is_array($param) && count($param)){
			return $param;
		}

		return '';
	}
}
//trả về: chuỗi bị cắt từ 0 tới kí tự thứ n
//đầu vào: $str chuỗi bị cắt, $n cắt bn kí tự
if(!function_exists('cutnchar')){
	function cutnchar($str = NULL, $n = 320){
		if(strlen($str) < $n) return $str;
		$html = substr($str, 0, $n);
		$html = substr($html, 0, strrpos($html,' '));
		return $html.'...';
	}
}


if(!function_exists('match_2_arrays')){
	function match_2_arrays(array $catalogue = [], array $index = []){
		$new = [];
		foreach ($catalogue as $key => $val) {
			$new[$val['id']]['title'] = $val['title'];
			$new[$val['id']]['keyword'] = $val['keyword'];
			$new[$val['id']]['data'] = [];
			foreach ($index as $keyChild => $valChild) {
				if($val['id'] == $valChild['catalogueid']){
					$abc = array_push($new[$val['id']]['data'], $valChild);
				}
			}
		}

		return $new;
	}
}


if(!function_exists('gettime')){
	function gettime($time, $type = 'H:i - d/m/Y'){
		if($type == 'datetime'){
			$type = 'Y-m-d H:i:s';
		}
		if($type == 'date'){
			$type = 'Y-m-d';
		}
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('getthumb')){
	function getthumb(string $string = '', bool $thumb = true){
		$image = '';

		if(!file_exists(dirname(dirname(dirname(__FILE__))).$image) ){
			$image = 'public/not-found.png';
		}
		if($thumb == TRUE){
			$thumbUrl = str_replace('/upload/image', '/upload/thumb/Images', $string);
			if (file_exists(dirname(dirname(dirname(__FILE__))).$thumbUrl)){
				return $thumbUrl;
			}
		}
		return $string;
	}
}


if (! function_exists('password_encode')){
	function password_encode(string $password, string $salt): string{
		return md5(md5($salt.$password));
	}
}


if (! function_exists('pre')){
	function pre($param, $flag = true){
		echo '<pre>';
		print_r($param);
		if($flag == true){
			die();
		}

	}
}

if (! function_exists('convertArrayByValue')){
	function convertArrayByValue($text, $data, $field, $value){
		$array[0] = 'Chọn '.$text.'';
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				$array[$val[$field]] = $val[$value];
			}
		}
		return $array;
	}
}


if (! function_exists('convertArray')){
	function convert_array($param){
		$array[0] = 'Chọn '.$param['text'].'';
		if(isset($param['data']) && is_array($param['data']) && count($param['data'])){
			foreach($param['data'] as $key => $val){
				$array[$val[$param['field']]] = $val[$param['value']];
			}
		}

		return $array;
	}
}



// tạo thông báo
if(!function_exists('show_flashdata')){
	function show_flashdata($body = TRUE){;
		$result = [];
		$session = session();
		$message = $session->getFlashdata('message-success');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 0;
			return $result;
		}
		$message = $session->getFlashdata('message-danger');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 1;
		}


		return $result;
	}
}


if(!function_exists('removeutf8')){
	function removeutf8($value = NULL){
		$chars = array(
			'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'	=>	array('đ','Đ'),
		);
		foreach ($chars as $key => $arr)
			foreach ($arr as $val)
				$value = str_replace($val, $key, $value);
		return $value;
	}
}

if(!function_exists('slug')){
	function slug($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('-', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '-', trim($value)));
	}
}

if(!function_exists('slug_database')){
	function slug_database($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('_', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '_', trim($value)));
	}
}

?>
