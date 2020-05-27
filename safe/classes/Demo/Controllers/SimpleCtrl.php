<?php
namespace Demo\Controllers;

class SimpleCtrl extends \FlightControl\BaseCtrl{

	public function start(){
		$this->data['version'] = $this->container->get('fc_version');
		$this->data['date'] = date('Y-m-d');
	}

}