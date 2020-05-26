<?php
namespace Demo\Controllers;

/**
*/
class LogoutCtrl extends \FlightControl\BaseCtrl{

	private $redirect;

	public function getView(){
		return '';
	}

	public function getRedirect(){
		return $this->redirect;
	}

	public function start(){

		$_SESSION['username']='';
		$_SESSION['password']='';
		$_SESSION['loggedin']=false;

	}

	public function __construct($redirect){

		$this->redirect = $redirect;

	}

}