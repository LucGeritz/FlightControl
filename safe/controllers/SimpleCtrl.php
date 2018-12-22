<?php
class SimpleCtrl extends BaseCtrl{
	
	public function start(){
		$this->data['version'] = Flight::get('fc_version');
		$this->data['date'] = date('Y-m-d');
	}
	
}