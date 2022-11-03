<?php

namespace App\Repositories;
use App\Repositories\Interfaces\AttributeRepositoryInterface;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
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
            tb1.attribute_catalogue_id,
            tb1.catalogue,
            tb1.publish,
            tb1.created_at,
            tb2.title,
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            ['attribute_translate as tb2','tb1.id = tb2.attribute_id','inner']
         ],
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
			'query' => $query,
			'join' => [
            [
               'attribute_translate as tb2', 'tb1.id = tb2.attribute_id', 'inner'
            ],
				[
					'attribute_catalogue_attribute as tb3', 'tb1.id = tb3.attribute_id', 'inner'
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
            tb1.attribute_catalogue_id,
            tb1.catalogue,
            tb1.viewed,
            tb1.order,
            tb1.created_at,
            tb1.publish,
            tb2.title,
            (
               SELECT title
               FROM attribute_catalogue_translate
               WHERE tb4.id = attribute_catalogue_translate.attribute_catalogue_id
            ) as cat_title,
         ',
         'table' => $this->table.' as tb1',
         'keyword' => $keyword,
			'where' => $condition,
			'query' => $query,
			'join' => [
            [
               'attribute_translate as tb2', 'tb1.id = tb2.attribute_id', 'inner'
            ],
				[
					'attribute_catalogue_attribute as tb3', 'tb1.id = tb3.attribute_id', 'inner'
				],
            [
               'attribute_catalogues as tb4', 'tb1.attribute_catalogue_id = tb4.id', 'inner'
            ],
			],
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'group_by' => 'tb1.id',
         'order_by'=> 'tb1.id desc'
      ], TRUE);
   }
}
