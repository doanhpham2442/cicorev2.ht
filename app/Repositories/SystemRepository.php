<?php

namespace App\Repositories;
use App\Repositories\Interfaces\SystemRepositoryInterface;

class SystemRepository extends BaseRepository implements SystemRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function findByField($value, string $field, $language){
      return $this->model->_get_where([
         'select' => '
            tb1.*,
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            $field => $value,
            'tb1.deleted_at' => 0,
            'tb1.language' => $language
         ]
      ]);
   }

   public function deleteConfig($language){
      return $this->model->_delete([
         'table' => $this->table,
         'where' => [
            'language_id' => $language
         ]
      ]);
   }

}
