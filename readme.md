#FlightControl
FlightControl adds real controllers and view templates to [Flight](flightphp.com). Flight itself aims at RESTful application but with FlightControl you can build webpage applications where logic and presentation are separated. 

It also adds a system of reusable modules.

##Installation
Make sure you have installed Flight on your webserver, see <http://flightphp.com/install>. 
Next download or clone FlightControl and place it in a folder of its own on your webserver as well. 

If you're running nginx instead of Apache then look on <http://flightphp.com/install> how to configure the rewrites. You'll need these to make FlightControl work (or any Flight-based application). 
 
Open in the FlightControl folder the file `index.php` and if necessary change the line  

    require '../flight/Flight.php';

in such a way that `Flight.php` can be found.


The demo FlightControl application should be up and running. It contains some useful examples on how to use FlightControl. Also scan through the source files, they contain a lot of comments.
 
Happy programming!
