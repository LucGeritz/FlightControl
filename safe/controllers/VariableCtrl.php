<?php
class VariableCtrl extends BaseCtrl{
	
	private $ip; 
	
	public function getView(){
		
		return ($this->data['secs'] %2 == 0) ? 'evenView' : 'oddView';				
	}

	public function start(){
		$this->data['secs'] = (int)date('s');
		$this->data['ip'] = $this->ip;
	}
	
	public function __construct($ip){
		$this->ip = $ip;
	}
	
		
}