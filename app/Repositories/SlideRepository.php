<?php

namespace App\Repositories;
use App\Repositories\Interfaces\SlideRepositoryInterface;

class SlideRepository extends BaseRepository implements SlideRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function findByField($value, string $field, int $language){
      return $this->model->_get_where([
         'select' => '
            tb1.title,
            tb1.keyword,
            tb1.description,
            tb2.image,
            tb2.title as slide_title,
            tb2.description as slide_description,
            tb2.canonical,
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            ['slide_translate as tb2','tb1.id = tb2.slide_id', 'inner']
         ],
         'where' => [
            $field => $value,
            'tb1.deleted_at' => 0,
            'tb2.language_id' => $language,
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

   public function deleteSlide($id, $table ,$language){
      return $this->model->_delete([
         'table' => $table,
         'where' => [
            'slide_id' => $id,
            'language_id' => $language
         ]
      ]);
   }


}
