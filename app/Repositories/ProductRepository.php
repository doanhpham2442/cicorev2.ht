<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
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
            tb1.product_catalogue_id,
            tb1.catalogue,
            tb1.album,
            tb1.image,
            tb1.price,
            tb1.price_sale,
            tb1.code,
            tb1.made_in,
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
            ['product_translate as tb2','tb1.id = tb2.product_id','inner']
         ],
         'where' => [
            $field => $value,
            'tb1.deleted_at' => 0
         ]
      ]);
   }

   public function countIndex($productCatalogue){
      return $this->model->_get_where([
         'select' => '
            tb1.id
         ',
			'table' => $this->table.' as tb1',
			'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
         ],
         'query' => '
            tb3.product_catalogue_id IN (
               SELECT pc.id
               FROM product_catalogues as pc
               WHERE pc.lft >= '.$productCatalogue['lft'].' AND pc.rgt <= '.$productCatalogue['rgt'].'
            )
         ',
			'join' => [
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
			],
			'group_by' => 'tb1.id',
			'count' => TRUE,
      ]);
   }

   public function paginateIndex(array $productCatalogue, array $config, int $page){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.product_catalogue_id,
            tb1.catalogue,
            tb1.image,
            tb1.viewed,
            tb1.order,
            tb1.created_at,
            tb1.album,
            tb1.publish,
            tb2.title,
            tb2.canonical,
            tb1.price,
            tb1.price_sale,
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
         ],
         'query' => '
            tb3.product_catalogue_id IN (
               SELECT pc.id
               FROM product_catalogues as pc
               WHERE pc.lft >= '.$productCatalogue['lft'].' AND pc.rgt <= '.$productCatalogue['rgt'].'
            )
         ',
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
			],
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'group_by' => 'tb1.id',
         'order_by'=> 'tb1.id desc'
      ], TRUE);
   }

   public function count(array $condition,  string $keyword = '', string $query = ''){
      return $this->model->_get_where([
         'select' => 'tb1.id',
			'table' => $this->table.' as tb1',
			'keyword' => $keyword,
			'where' => $condition,
			'query' => $query,
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
			],
			'group_by' => 'tb1.id',
			'count' => TRUE,
      ]);
   }

   public function paginate(array $condition, string $keyword,  string $query = '', array $config, int $page){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.product_catalogue_id,
            tb1.catalogue,
            tb1.image,
            tb1.viewed,
            tb1.order,
            tb1.created_at,
            tb1.album,
            tb1.publish,
            tb2.title,
            tb2.canonical,
            (
               SELECT title
               FROM product_catalogue_translate
               WHERE tb4.id = product_catalogue_translate.product_catalogue_id
            ) as cat_title,
         ',
         'table' => $this->table.' as tb1',
         'keyword' => $keyword,
			'where' => $condition,
			'query' => $query,
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
            [
               'product_catalogues as tb4', 'tb1.product_catalogue_id = tb4.id', 'inner'
            ],
			],
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'group_by' => 'tb1.id',
         'order_by'=> 'tb1.id desc'
      ], TRUE);
   }

   public function search($keyword, $start, $language = 2){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb1.image,
            tb2.canonical,

         ',
         'table' => $this->table.' as tb1',
         'keyword' => '(tb2.title LIKE \'%'.$keyword.'%\')',
         'where' => [
            'tb1.deleted_at' => 0,
            'tb2.language_id' => $language
         ],
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
			],
         'limit' => 15,
         'start' => $start,
         'group_by' => 'tb1.id',
         'order_by'=> 'tb1.id desc'
      ], TRUE);

   }

   public function findProductByCatalogueId($query = ''){
      return  $this->model->_get_where([
         'select' => '
            tb1.id
         ',
         'table' => $this->table.' as tb1',
			'where' => [
            'tb1.deleted_at' => 0,
         ],
			'query' => $query,
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
			],
         'group_by' => 'tb1.id',
      ], TRUE);
   }

   public function findProductByIdArray($id){
      return  $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.image,
            tb1.price,
            tb1.price_sale,
            tb2.title,
            tb2.canonical
         ',
         'table' => $this->table.' as tb1',
			'where' => [
            'tb1.deleted_at' => 0,
         ],
         'where_in' => $id,
         'where_in_field' => 'tb1.id',
			'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
				[
					'product_catalogue_product as tb3', 'tb1.id = tb3.product_id', 'inner'
				],
			],
         'group_by' => 'tb1.id',
      ], TRUE);
   }

   public function productRelate($product_catalogue_id = 0, $limit){
      return $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.price,
            tb1.price_sale,
            tb1.image,
            tb2.title,
            tb2.canonical,
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            [
               'product_translate as tb2', 'tb1.id = tb2.product_id', 'inner'
            ],
			],
         'where' => [
            'tb1.product_catalogue_id' => $product_catalogue_id
         ],
         'limit' => $limit,
         'order_by' => 'RAND()'
      ], TRUE);
   }

}