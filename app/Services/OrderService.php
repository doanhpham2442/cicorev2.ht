<?php

namespace App\Services;
use App\Libraries\Authentication as Auth;


class OrderService
{

   protected $module;
   protected $language;
   protected $db;
   protected $request;
   protected $pagination;
   protected $orderRepository;
   protected $cartBie;

   public function __construct($param){
      $this->module = $param['module'];
      $this->language = $param['language'];
      $this->db = \Config\Database::connect();
      $this->request = \Config\Services::request();
      $this->pagination = service('Pagination');
      $this->orderRepository = service('OrderRepository', $this->module);
      $this->cartBie = service('cartBie');
   }

   public function create($cart){
      $this->db->transBegin();
      try{
         $cart = $this->cartBie->formatCart($cart);
         $payload = requestAccept(['fullname', 'email', 'phone', 'address', 'city_id', 'district_id', 'ward_id', 'description', 'paymentMethod', 'voucherDiscountValue', 'voucher', 'voucherDiscountType']);
         $payload['code'] = GetSerialCode();
         $payload['cart'] = json_encode($cart['newCart']);
         $payload['created_at'] = currentTime();
         $id = $this->orderRepository->create($payload);
         if($id > 0){
            $payloadRelation = [];
            if(isset($cart['newCart']) && is_array($cart['newCart']) && count($cart['newCart'])){
               foreach($cart['newCart'] as $key => $val){
                  $payloadRelation[] = [
                     'order_id' => $id,
                     'product_id' => $val['product_id'],
                     'quantity' => $val['qty'],
                     'name' => $val['name'],
                     'price' => $val['price'],
                     'option' => json_encode($val['option'])
                  ];
               }
            }
            $this->orderRepository->createBatch($payloadRelation, 'order_product');
         }

         $this->db->transCommit();
         $this->db->transComplete();
         return [
            'flag' => TRUE,
            'code' => $payload['code']
         ];

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return [
            'flag' => FALSE,
            'code' => ''
         ];
      }
   }


   public function paginate($page){
      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $keyword = $this->keyword();
      $condition = $this->condition();


      $config['total_rows'] = $this->orderRepository->count($condition, $keyword);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => route('backend.order.order.index'),'perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$order = $this->orderRepository->paginate($condition, $keyword, $config, $page);

         $orderId = array_column($order, 'id');
         $orderDetail = $this->orderRepository->findOrderDetailByIdArray($orderId);
         foreach($order as $key => $val){
            foreach($orderDetail as $item){
               if($item['order_id'] == $val['id']){
                  $order[$key]['detail'][] = $item;
               }
            }
         }

		}
      return [
         'pagination' => ($pagination) ?? '',
         'list' => ($order) ?? [],
      ];
   }


   public function delete($id){
      $id = (int)$id;
      try{
         /* Xóa bản ghi - xóa order */
         $this->orderRepository->softDelete($id);
         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         dd($e);
         return false;
      }

   }


   private function condition(){
      $condition = [];
      if($this->request->getGet('publish')){
         $condition['publish'] = $this->request->getGet('publish');
      }
      $condition['deleted_at'] = 0;

      return $condition;
   }

   private function keyword(): string{
      $search = '';
      if(!empty($this->request->getGet('keyword'))){
         $fieldSearch = ['fullname', 'email', 'description', 'code'];

         $keyword = $this->request->getGet('keyword');
         if(isset($fieldSearch) && is_array($fieldSearch) && count($fieldSearch)){
            foreach($fieldSearch as $key => $val){
               if(empty($search)){
                  $search = '('.$val.' LIKE \'%'.$keyword.'%\')';
               }else{
                  $search = $search.' OR '.'('.$val.' LIKE \'%'.$keyword.'%\')';
               }

            }
         }
      }
      return $search;
   }



}
