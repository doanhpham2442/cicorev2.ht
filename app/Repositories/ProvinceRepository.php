<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function allProvince(){
      return $this->model->_get_where([
         'select' => '*',
         'table' => $this->table,
         'order_by' => 'order desc'
      ], TRUE);
   }

   public function findCityById($cityId = 0){
      return $this->model->_get_where([
         'select' => '*',
         'table' => $this->table,
         'where' => [
            'provinceid' => $cityId
         ]
      ]);
   }

   public function findDistrictById($districtId = 0){
      return $this->model->_get_where([
         'select' => '*',
         'table' => 'vn_district',
         'where' => [
            'districtid' => $districtId
         ]
      ]);
   }

}
