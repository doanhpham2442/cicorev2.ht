<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;
    protected $table;

   /**
   * BaseRepository constructor.
   *
   * @param Model $model
   */
   public function __construct($table)
   {
     $this->table = $table;
   }

   public function all(string $column = '*', array $join = [], int $language = 2){
      return $this->model->_get_where([
         'select' => $column,
         'table' => $this->table,
         'where' => [
            'deleted_at' => 0,
            'language_id' => $language
         ]
      ], TRUE);
   }


   public function findById(int $id){
      return $this->model->_get_where([
         'select' => '*',
         'table' => $this->table,
         'where' => [
            'id' => $id,
         ]
      ]);
   }



   public function create(array $payload = []){
      return $this->model->_insert([
         'data' => $payload,
         'table' => $this->table,
      ]);
   }

   public function createTranslate($payload, $table){
      return $this->model->_insert([
         'data' => $payload,
         'table' => $table,
      ]);
   }

   public function update(array $payload, int $id){
      return $this->model->_update([
         'data' => $payload,
         'table' => $this->table,
         'where' => [
            'id' => $id
         ]
      ]);
   }

   public function updateTranslate(array $payload, string $table, array $condition){
      return $this->model->_update([
         'data' => $payload,
         'table' => $table,
         'where' => $condition
      ]);
   }

   public function createBatch($data, $table){
      return $this->model->_create_batch([
         'data' => $data,
         'table' => $table,
      ]);
   }

   public function softDelete(int $id){
      return $this->model->_update([
         'data' => [
            'deleted_at' => 1
         ],
         'table' => $this->table,
         'where' => [
            'id' => $id,
         ]
      ]);
   }

   public function delete(int $id){

   }

   public function createRelation(array $relation = [], string $table = ''){
      return $this->model->_create_batch([
         'data'=> $relation,
         'table' => $table
      ]);
   }

   public function deleteRelation(int  $id, string $table, string $foreignkey = ''){
      return $this->model->_delete([
         'table' => $table,
         'where' => [
            $foreignkey => $id,
         ]
      ]);
   }


   public function getChildNode($lft, $rgt){
      return $this->model->_get_where([
         'select' => 'id',
         'table' => $this->table,
         'where' => [
            'lft >=' => $lft,
            'rgt <=' => $rgt
         ]
      ], TRUE);
   }


}
