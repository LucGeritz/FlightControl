<?php
namespace FlightControl;

abstract class BaseCtrl implements IController{

	protected $data;

	public function getData(){
		return $this->data;
	}

	// please override if you want your controller to tell what view to use
	public function getView(){
		return null;
	}

	// please override if you want your controller to tell where to redirect to
	// the pilot only asks for redirection if no view is available
	public function getRedirect(){
		return null	;
	}

	public function isAuth(){
		return true;
	}

}