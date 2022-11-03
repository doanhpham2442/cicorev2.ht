<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;

class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
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
            tb1.id,
            tb1.parentid,
            tb1.lft,
            tb1.rgt,
            tb1.level,
            tb1.album,
            tb1.image,
            tb1.icon,
            tb1.publish,
            tb2.title,
            tb2.canonical,
            tb2.description,
            tb2.content,
            tb2.meta_title,
            tb2.meta_description,
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            ['product_catalogue_translate as tb2','tb1.id = tb2.product_catalogue_id','inner']
         ],
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
         'join' => [
            ['product_catalogue_translate as tb2','tb1.id = tb2.product_catalogue_id','inner']
         ],
         'keyword' => $keyword,
         'count' => TRUE
      ]);
   }

   public function paginate(array $condition, string $keyword, array $config, int $page){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb1.lft,
            tb1.rgt,
            tb1.level,
            tb2.canonical,
            (SELECT fullname FROM users WHERE users.id = tb1.userid_created) as creator,
            tb1.userid_updated,
            tb1.publish,
            tb1.order,
            tb1.created_at,
            tb1.updated_at
         ',
         'table' => $this->table.' as tb1',
         'where' => $condition,
         'keyword' => $keyword,
         'join' => [
            ['product_catalogue_translate as tb2','tb1.id = tb2.product_catalogue_id','inner']
         ],
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'order_by'=> 'lft asc'
      ], TRUE);
   }

   public function allProductCatalogue($language = 2){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.parentid,
            tb1.icon,
            tb1.lft,
            tb1.rgt,
            tb1.level,
            tb1.publish,
            tb1.order,
            tb1.created_at,
            tb1.updated_at,
            tb2.canonical,
            tb2.title,
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            'tb1.deleted_at' => 0,
            'tb2.language_id' => $language
         ],
         'join' => [
            ['product_catalogue_translate as tb2','tb1.id = tb2.product_catalogue_id','inner']
         ],
         'order_by'=> 'id desc'
      ], TRUE);
   }

   public function search($keyword, $start, $language = 2){
      return   $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb2.canonical,
            tb1.image,
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            'tb1.deleted_at' => 0,
            'tb2.language_id' => $language
         ],
         'keyword' => '(tb2.title LIKE \'%'.$keyword.'%\')',
         'join' => [
            ['product_catalogue_translate as tb2','tb1.id = tb2.product_catalogue_id','inner']
         ],
         'order_by'=> 'id desc',
         'limit' => 15,
         'start' => $start,
      ], TRUE);
   }

   public function findByIdArray(array $catalogue_id){
      return   $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.lft,
            tb1.rgt,
            tb1.image,
            tb2.canonical,
            tb2.title,
            (
               SELECT COUNT(p.id)
               FROM products as p
               JOIN product_catalogue_product as pcp ON pcp.product_id = p.id
               WHERE pcp.product_catalogue_id IN (
                  SELECT pc.id
                  FROM product_catalogues as pc
                  WHERE pc.lft >= tb1.lft AND pc.rgt <= tb1.rgt
               )
            ) as totalProduct
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            'tb1.deleted_at' => 0,
         ],
         'join' => [
            [
               'product_catalogue_translate as tb2', 'tb1.id = tb2.product_catalogue_id', 'inner'
            ],
         ],
         'where_in' => $catalogue_id,
         'where_in_field' => 'tb1.id',
         'order_by'=> 'id desc',
      ], TRUE);
   }


}
