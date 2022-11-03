<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;


class Product extends BaseController{

   protected $language;

	public function __construct(){
      $this->language = $this->currentLanguage();
	}

	public function pre_select2(){
		$param['value'] = json_decode($this->request->getPost('value'));
		$param['module'] = $this->request->getPost('module');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['language'] = $this->request->getPost('language');
		$param['key'] = $this->request->getPost('key');
		if(isset($param['language'])&& $param['language'] !=''){
			$language = $param['language'];
		}else{
			$language = $this->currentLanguage();
		}
		$object = [];



		if($param['value'] != ''){
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.'.$param['select'].'',
				'table' => $param['module'].' as tb1',
            'join' => [
               [
                  $param['join'].' as tb2', 'tb1.id = tb2.'.$param['key'].'','inner'
               ],
            ],
				'where_in' => $param['value'],
				'where_in_field' => 'tb2.'.$param['key'].'',
				'order_by' => ''.$param['select'].' asc'
			], TRUE);
		}

		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}
		echo json_encode(array('items' => $temp));die();

	}

	public function get_select2(){
		$param['module'] = $this->request->getPost('module');
		$param['keyword'] = $this->request->getPost('locationVal');
		$param['select'] = $this->request->getPost('select');
		$param['join'] = $this->request->getPost('join');
		$param['language'] = $this->request->getPost('language');
		$param['key'] = $this->request->getPost('key');
		$param['catalogueid'] = $this->request->getPost('catalogueid');

      if(isset($param['language']) && $param['language'] != ''){
         $language = $param['language'];
      }else{
         $language = $this->language;
      }

		if(isset($param['language'])&& $param['language'] !=''){
			$language = $param['language'];
		}else{
			$language = $this->currentLanguage();
		}


      $object = [];
      try{
         $object = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.'.$param['select'].'',
            'table' => $param['module'].' as tb1',
            'join' => [
               [
                  $param['join'].' as tb2', 'tb1.id = tb2.'.$param['key'].'','inner'
               ],
            ],
            'where' => [
               'tb1.deleted_at' => 0,
               'tb2.language_id' => $language,
               'tb1.attribute_catalogue_id' => $param['catalogueid']
            ],
            'keyword' => '('.$param['select'].' LIKE \'%'.$param['keyword'].'%\')',
            'order_by' => ''.$param['select'].' asc'
         ], TRUE);
      }catch(\Exception $e ){
         pre($e->getMessage());
      }




		$temp = [];
		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $index => $val){
				$temp[] = array(
					'id'=> $val['id'],
					'text' => $val[$param['select']],
				);
			}
		}

		echo json_encode(array('items' => $temp));die();

	}

}
