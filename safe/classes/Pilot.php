<?php
class Pilot{

	protected $unAuthCallback;
	
	public function setUnauthView($view){
		$this->setUnauthView=$view;	
	}

	public function fly(IController $controller,$viewName = null){
	
		if(!$controller->isAuth()){
			if(isset($this->unAuthCallback)){
				$callback = $this->unAuthCallback;
				$viewName = null;
				$controller = $callback(Flight::request()->url);
			}
			else{
				// we need authorization for this controller
				// .. but no unauth-controller supplied
				throw new Exception('Unauthorized');
			}
		}
		
		$skip = $controller->start();
		
		if($skip===true){
			// skip to next route
			return true;	
		}
		
		if(!$viewName){
			$viewName = $controller->getView();
		}
		
		if($viewName){
			$data = $controller->getData();
			if($data){
				foreach($data as $k=>$v){
					Flight::view()->setVar($k,$v);	
				}
			}	
			Flight::render($viewName);
		}
		else{
			// no view, maybe controller want to redirect
			$redir = $controller->getRedirect();
			if($redir){
				Flight::redirect($redir);	
			}
			else{
				throw new Exception('Nowhere to go');
			}
		}
	}

	public function __construct($unAuthCallback = null){
		$this->unAuthCallback = $unAuthCallback;	
	}
	
}