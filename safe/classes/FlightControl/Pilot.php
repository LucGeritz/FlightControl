<?php
namespace FlightControl;

class Pilot{

	protected $unAuthCallback;
	protected $container;

	public function setUnauthView($view){
		$this->setUnauthView=$view;
	}

	public function fly(IController $controller,$viewName = null){

		if(!$controller->isAuth()){
			if(isset($this->unAuthCallback)){
				$callback = $this->unAuthCallback;
				$viewName = null;
				$controller = $callback($this->container->request()->url);
			}
			else{
				// we need authorization for this controller
				// .. but no unauth-controller supplied
				throw new \Exception('Unauthorized');
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
					$this->container->view()->setVar($k,$v);
				}
			}
			$this->container->render($viewName);
		}
		else{
			// no view, maybe controller want to redirect
			$redir = $controller->getRedirect();
			if($redir){
				$this->container->redirect($redir);
			}
			else{
				throw new \Exception('Nowhere to go');
			}
		}
	}

	public function __construct($container, $unAuthCallback = null){
		$this->container = $container;
		$this->unAuthCallback = $unAuthCallback;
	}

}