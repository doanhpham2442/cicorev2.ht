<?php
namespace App\Controllers\Frontend\Cart;
use App\Controllers\FrontendController;

class Cart extends FrontendController{
   protected $productService;
   protected $language;
   protected $systemRepository;
   protected $productRepository;
   protected $promotionRepository;
   protected $cartBie;
   protected $productCatalogueRepository;
   protected $provinceRepository;
   protected $orderService;
   protected $orderRepository;



	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->productService = service('ProductService',
         ['language' => $this->language, 'module' => 'products']
      );
      $this->reviewService = service('ReviewService',
         ['language' => $this->language, 'module' => 'product_reviews']
      );
      $this->orderService = service('OrderService',
         ['language' => $this->language, 'module' => 'orders']
      );
      $this->productCatalogueRepository = service('ProductCatalogueRepository', 'product_catalogues');
      $this->systemRepository = service('SystemRepository', 'systems');
      $this->productRepository = service('ProductRepository', 'products');
      $this->promotionRepository = service('PromotionRepository', 'promotions');
      $this->reviewRepository = service('ReviewRepository', 'product_reviews');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->orderRepository = service('OrderRepository', 'orders');
      $this->cartBie = service('cartbie');

	}

	public function index($id = 0, $page = 1){

      // pre($this->cart->contents());
      $voucher = [];
      $voucherApplyed = [];
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $productCatalogueList = $this->productCatalogueRepository->allProductCatalogue($this->language);
      $productCatalogueList = recursive($productCatalogueList);
      $seo = [
         'meta_title' => 'Giỏ Hàng',
         'meta_description' => 'Trang thanh toán',
         'canonical' => write_url('gio-hang', TRUE, FALSE)
      ];

      $province = converProvinceArray($this->provinceRepository->allProvince());
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $cart = $this->cartBie->formatCart($this->cart);
      if(isset($cart['newCart']) && is_array($cart['newCart']) && count($cart['newCart'])){
         $voucher = $this->cartBie->findVoucherCart($cart);
         $voucherApplyed = $this->cartBie->voucherApplyed();
      }
      $template = route('frontend.cart.index');
      $js = ['cart','core'];
      $css = ['cart'];
      $validate = [];
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            $create = $this->orderService->create($this->cart);
            if($create['flag'] == TRUE){
               $this->cart->destroy();
               $this->destroyVoucher();
               return redirect()->to(write_url('dat-hang-thanh-cong').'?orderId='.$create['code']);
            }else{
               $this->session->setFlashdata('message-danger', 'Đặt hàng không thành công, vui lòng thử lại!');
               return redirect()->to(write_url('gio-hang'));
            }
         }else{
            $validate = $this->validator;
         }
		}
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'productCatalogueList', 'product','canonical', 'general', 'js', 'seo','cart','css','voucher', 'voucherApplyed', 'province', 'validate'
         )
      );
	}

   public function orderSuccess(){

      $orderDetail = [];
      $orderId = request()->getGet('orderId');
      $order = $this->orderRepository->findByField($orderId, 'code');
      if(isset($order) && is_array($order) && count($order)){
         $orderDetail = $this->orderRepository->orderDetailByOrderId($order['id']);
      }

      $template = route('frontend.cart.success');
      $general = convertGeneral($this->systemRepository->all('keyword, content'));
      $product['count'] = $this->productRepository->count(['deleted_at' => 0]);
      $cart = $this->cartBie->formatCart($this->cart);
      $js = ['cart','core'];
      $css = ['cart'];
      $seo = [
         'meta_title' => 'Đặt hàng thành công tại hệ thống website: '.$general['contact_website'].' mã đơn hàng: '.$orderId.'',
         'meta_description' => 'Trang thanh toán',
         'canonical' => write_url('gio-hang', TRUE, FALSE)
      ];
		return view(route('frontend.homepage.layout.home'),
         compact(
            'template', 'general', 'product', 'seo', 'cart', 'css', 'js', 'order', 'orderDetail'
         )
      );
   }


   public function destroyVoucher(){
      if (isset($_COOKIE['voucher'])) {
         unset($_COOKIE['voucher']);
         setcookie('voucher', null, -1, '/');
         return true;
      } else {
         return false;
      }
   }


   private function validation(){
		$validate = [
			'fullname' => 'required',
			'phone' => 'required',
         'email' => 'required|valid_email',
         'address' => 'required',
         'paymentMethod' => 'required',
         'city_id' => 'required',
         'district_id' => 'required',
		];
		$errorValidate = [
			'fullname' => [
				'required' => 'Bạn chưa nhập Họ Tên'
			],
         'phone' => [
            'required' => 'Bạn chưa nhập Số điện thoại'
         ],
         'address' => [
            'required' => 'Bạn chưa nhập địa chỉ'
         ],
         'paymentMethod' => [
            'required' => 'Bạn chưa chọn hình thức thanh toán'
         ],
         'city_id' => [
            'is_natural_no_zero' => 'Bạn chưa chọn Tỉnh/Thành Phố'
         ],
         'district_id' => [
            'is_natural_no_zero' => 'Bạn chưa chọn Quận/Huyện'
         ],
         'email' => [
            'required' => 'Bạn chưa nhập email',
            'email' => 'Email không đúng định dạng',
         ],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}




}
