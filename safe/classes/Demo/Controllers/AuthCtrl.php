<?php
namespace Demo\Controllers;

/**
* The auth controller determines if the user is allowed to start this controller
* It is an extra layer between baseCtrl and the specific controller
* FlightControl does not contain a security component. It is up to the consumer.
* This AuthCtrl class can serve as a base though.
*/
abstract class AuthCtrl extends \FlightControl\BaseCtrl{

	private function checkAuth($user, $password){

		return $user=='demo' && $password=='demo';

	}

	public function isAuth(){

		$loggedIn = false;

		if(isset($_POST['submit-login'])){
			// credentials were submitted
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
		}

		if(isset($_SESSION['username']) && isset($_SESSION['password'])){
			$loggedIn = $this->checkAuth($_SESSION['username'], $_SESSION['password']);
		}

		$_SESSION['loggedin']=$loggedIn;

		if(!$loggedIn && isset($_POST['submit-login'])){
			$this->container->view()->setVar('error','Invalid username or password');
		}

		$this->container->view()->setVar('loggedIn',$loggedIn);
		return $loggedIn;

	}


}