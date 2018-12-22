<?php
/**
*/
class LoginCtrl extends BaseCtrl{
	
	private $url; // the requested url before we 'redirected' to the login
		
	public function getView(){
		return 'loginView';		
	}
	
	public function start(){
	
	
		$this->data['url']=$this->url;
			
		if(isset($_SESSION['username'])){
			$this->data['username']=$_SESSION['username'];
		}
		elseif(isset($_POST['username'])){
			$this->data['username']=$_POST['username'];
		}
		else{
			$this->data['username']='';		
		}
		
		if(isset($_SESSION['password'])){
			$this->data['password']=$_SESSION['password'];
		}
		elseif(isset($_POST['username'])){
			$this->data['password']=$_POST['password'];
		}
		else{
			$this->data['password']='';		
		}
	
	}
	
	public function __construct($url){

		$this->url = $url;
		
	}
	
}