<?php
// Register and map classes/methods

/********************************************************************************************
 Register module loader
 Register the ModLoader loader class as 'module'
 - If you load any FlightControl modules you'll need these lines, otherwise comment them out
 - You could change the base directory of the modules, here 'safe/modules', if you want to
   place your modules somewhere else.
*/
Flight::register('module','FlightControl\ModLoader',['safe/modules',function($dir){Flight::path($dir);}]);

/*******************************************************************************************
   Map the base method
*/
Flight::map('base',function(){
	$base = Flight::request()->base;
	return $base == '/' ? '' : $base;
});

/********************************************************************************************
   Register view handler
   Override the default view system by one using Templum
   - FlightControl uses Templum so leave these lines
*/
Flight::register('view', 'Templum\Templum', ['safe/views'], function($view){
	$view->setAutoEscape(true);
	$view->setVar('mainView','layout'); // <== ***CONFIG*** name of the mainview
	$view->setVar('base',Flight::base());
	$view->setVar('active','');
});
// We'll need to override render() as well..
Flight::map('render',function($template,$data=[]){
	$tpl = Flight::view()->template($template);
	print($tpl->render($data));
});

/*******************************************************************************************
   Map the fly method
*/
Flight::map('fly',[new FlightControl\Pilot(function($url){
	// constructor parameter is the controller-object used in case user is unauthorized
	return new Demo\Controllers\LoginCtrl($url);
}),'fly']);

/*******************************************************************************************
   Register SLog
*/
Flight::register('logger','Slog', [dirname(__FILE__).DIRECTORY_SEPARATOR.'logs']);

/*******************************************************************************************
   Map notFound (override)
*/
Flight::map('notFound', function(){
	Flight::fly(new Demo\Controllers\Four04Ctrl(),'four04View');
});


