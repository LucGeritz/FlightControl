<?php
// Variable views
Flight::route('/variable', function(){
	Flight::view()->setVar('action','examples');
	Flight::fly(new Demo\Controllers\VariableCtrl(Flight::request()->ip));
});

// Log out
Flight::route('/logout', function(){
	Flight::fly(new Demo\Controllers\LogoutCtrl('/'));
});

// Simple
Flight::route('/simple', function(){
	Flight::view()->setVar('action','examples');
	Flight::fly((new Demo\Controllers\SimpleCtrl())->setContainer(Flight::app()),'simpleView');
});

// About
Flight::route('/get-started', function(){
	Flight::view()->setVar('action','get-started');
	Flight::render('get-startedView');
});

// About
Flight::route('/about', function(){
	Flight::view()->setVar('action','about');
	Flight::render('aboutView');
});

// Secret
Flight::route('/secret', function(){
	Flight::view()->setVar('action','examples');
	Flight::fly((new Demo\Controllers\SecretCtrl(Flight::request()->ip))->setContainer(Flight::app()));
});

// NoView
Flight::route('/noview', function(){
	Flight::view()->setVar('action','examples');
	Flight::render('noCtrlView');
});


// Examples
Flight::route('/examples', function(){
	Flight::view()->setVar('action','examples');
	Flight::render('examplesView');
});

// Home
Flight::route('/', function(){
	Flight::view()->setVar('action','home');
	Flight::render('homeView');
});
