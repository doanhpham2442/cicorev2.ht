<?php

namespace App\Repositories;
use App\Repositories\Interfaces\VoucherRepositoryInterface;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
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
            'tb1.deleted_at' => 0
         ]
      ]);
   }

   public function count(array $condition,  string $keyword, string $query = ''){
      return $this->model->_get_where([
         'select' => 'tb1.id',
			'table' => $this->table.' as tb1',
			'keyword' => $keyword,
			'where' => $condition,
			'group_by' => 'tb1.id',
			'count' => TRUE,
      ]);
   }

   public function paginate(array $condition, string $keyword, array $config, int $page){
      return  $this->model->_get_where([
         'select' => '
            tb1.*,
         ',
         'table' => $this->table.' as tb1',
         'keyword' => $keyword,
			'where' => $condition,
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'group_by' => 'tb1.id',
         'order_by'=> 'tb1.id desc'
      ], TRUE);
   }

   public function findProductByVoucher($voucherId  = [], $productId){
      return $this->model->_get_where([
         'select' => 'tb1.id, tb2.product_id',
         'table' => 'vouchers as tb1',
         'join' => [
            ['voucher_product as tb2','tb1.id = tb2.voucher_id','inner']
         ],
         'where' => [
            'tb1.start_at <=' => currentTime(),
            'tb1.end_at >=' => currentTime(),
            'tb1.publish' => 1,
            'tb1.title' => $voucherId,
            'tb1.type' => 'money',
         ],
         'where_in' => $productId,
         'where_in_field' => 'tb2.product_id'
      ], TRUE);
   }


   public function findAllVoucherCart($productId){
      $id = '';
      if(isset($productId) && is_array($productId) && count($productId)){
         $id = $id.'(';
         foreach($productId as $key => $val){
            $id = $id.$val.',';
         }
         $id = substr($id, 0, -1);
         $id = $id.')';
      }
      $query = '
         SELECT
            tb1.id,
            tb1.title,
            tb1.discount_value,
            tb1.discount_type,
            tb1.type,
            tb1.description,
            tb1.countLimitValue
         FROM vouchers as tb1
         INNER JOIN voucher_product as tb2 ON tb2.voucher_id = tb1.id
         WHERE
            tb1.start_at <= "'.currentTime().'"
            AND tb1.end_at >= "'.currentTime().'"
            AND tb1.publish = 1 AND tb2.product_id IN '.$id.'

         UNION

         SELECT
            tb1.id,
            tb1.title,
            tb1.discount_value,
            tb1.discount_type,
            tb1.type,
            tb1.description,
            tb1.countLimitValue
         FROM vouchers as tb1
         WHERE
            tb1.start_at <= "'.currentTime().'"
            AND tb1.end_at >= "'.currentTime().'"
            AND tb1.publish = 1
            AND tb1.type = "bill"

      ';
      return $this->model->_query($query);
   }



}
