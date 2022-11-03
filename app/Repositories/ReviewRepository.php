<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
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
            tb1.*,
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            $field => $value,
            'tb1.deleted_at' => 0
         ]
      ]);
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
            *
         ',
         'table' => $this->table,
         'where' => $condition,
         'keyword' => $keyword,
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'order_by'=> 'id desc'
      ], TRUE);
   }

   public function findReviewByProductId($product_id = 0){
      return $this->model->_get_where([
         'select' => '
            fullname,
            email,
            description,
            rate,
            created_at,
         ',
         'table' => $this->table,
         'where' => [
            'product_id' => $product_id,
            'deleted_at' => 0,
            'publish' => 1,
         ],
         'order_by' => 'rate desc'
      ], TRUE);
   }

   public function averateReviewByProductId($product_id = 0){
      return $this->model->_get_where([
         'select' => '
            COUNT(id) as totalReview,
            SUM(rate) as totalRate,
         ',
         'table' => $this->table,
         'where' => [
            'product_id' => $product_id,
            'deleted_at' => 0,
            'publish' => 1,
         ]
      ]);
   }


}
