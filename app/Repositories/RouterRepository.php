<?php

namespace App\Repositories;
use App\Repositories\Interfaces\RouterRepositoryInterface;

class RouterRepository extends BaseRepository implements RouterRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function deleteRouter($id, $module){
      return $this->model->_delete([
         'table' => $this->table,
         'where' => [
            'objectid' => $id,
            'module' => $module,
         ]
      ]);
   }

   public function findByField($value, $field){
      return $this->model->_get_where([
         'select' => '*',
         'table' => $this->table,
         'where' => [
            $field => $value,
         ]
      ]);
   }



}
