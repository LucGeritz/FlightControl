<?php
namespace Demo\Controllers;

/**
* A controllers main task is to fill $this->data, Controller.php passes
* this to the view.
*/
class Four04Ctrl extends \FlightControl\BaseCtrl{

	public function start(){
		$this->data = [
			'url' => \Flight::request()->base . \Flight::request()->url,
		];
	}

}