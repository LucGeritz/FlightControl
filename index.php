<?php
/**
* Based on Flight
* @see http://flightphp.com
*
* FlightControl adds Controllers and Template Views to Flight
* @author Luc Geritz
*/

/**
* This file is a demo. You will need some index.php though. You could use another bootstrap file
* but make sure the request is redirected to this other file.
* @see http://flightphp.com/install/
*
* Typically index.php will have to
* [1] include the Flight library
* [2] feed paths to the Flight autoloader, so Flight can find your own classes. To get FlightControl
*     .. up and running you'll need to keep the lines adding safe/classes and safe/classes/templum.
*     .. The rest is optional, you can include your classes explicitly or use your own autoloader to
*     .. assure your classes are located. If you do use your own autoloader, again index.php is the
*     .. place to include it.
* [3] extend Flight (register classes, map methods), This is the coolest part of Flight! At least you'll
*     need to map the Pilot::fly method, see the demo mappings.php. If you use modules (see [4]) make sure
*     the ModLoader class is registered here as well.
* [4] load the dependent FlightControl modules, if you use any.
* [5] define the routes
* [6] start Flight
*/

// This line is part of the demo. A session is needed to remember login settings. Remove it if your
// .. implementation doesn't use this
session_start();

// [1] make sure the require below will find Flight in your situation
// .. you might have to change it
require '../flight/Flight.php';

// THE VERSION OF FLIGHTCONTROL
Flight::set('fc_version','1.0.0');

// [2] Feed more paths to flight's autoloader
Flight::path('safe/classes');         // mandatory, FlightControl needs this to work
Flight::path('safe/controllers');     // decide on your strategy to make sure your classes will be found

// [3] do some mappings
include 'safe/mappings.php';

// [4] define the routes
include 'safe/routes.php';

// [5] start the router and go!
Flight::start();








