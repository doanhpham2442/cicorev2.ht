<?php

namespace App\Repositories;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function findByField($value, string $field){
      return $this->model->_get_where([
         'select' => '
            tb1.*
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            $field => $value,
         ]
      ]);
   }

   public function orderDetailByOrderId($orderId){
      return $this->model->_get_where([
         'select' => '
            *
         ',
         'table' => 'order_product',
         'where' => [
            'order_id' => $orderId,
         ]
      ], TRUE);
   }


   public function count(array $condition,  string $keyword){
      return $this->model->_get_where([
         'select' => 'tb1.id',
         'table' => $this->table.' as tb1',
         'where' => $condition,
         'keyword' => $keyword,
         'count' => TRUE
      ]);
   }

   public function paginate(array $condition, string $keyword, array $config, int $page){
      return  $this->model->_get_where([
         'select' => '
            *,
         ',
         'table' => $this->table,
         'where' => $condition,
         'keyword' => $keyword,
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'order_by'=> 'id desc'
      ], TRUE);
   }

   public function findOrderDetailByIdArray(array $orderId){
      return $this->model->_get_where([
         'select' => 'order_id, product_id, quantity, price, option',
         'table' => 'order_product',
         'where_in' => $orderId,
         'where_in_field' => 'order_id'
      ], TRUE);
   }

}
