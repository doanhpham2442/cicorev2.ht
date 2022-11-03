<?php

namespace App\Repositories;
use App\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository extends BaseRepository implements PromotionRepositoryInterface
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

   public function findPromotionByProductId($product_id  = 0){
      return $this->model->_get_where([
         'select' => 'tb1.id, tb1.discount_value, tb1.discount_type, tb2.product_id, tb1.type',
         'table' => 'promotions as tb1',
         'join' => [
            ['promotion_product as tb2','tb1.id = tb2.promotion_id','inner']
         ],
         'where' => [
            'tb2.product_id' => $product_id,
            'tb1.start_at <=' => currentTime(),
            'tb1.end_at >=' => currentTime(), 
         ]
      ], TRUE);
   }


}
