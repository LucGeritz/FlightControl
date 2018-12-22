<?php
/**
* Slog = Simple log, A simple class to log to a textfile.
* 
* Part of Tigrez.Slog which is an example of a FlightControl module
* Before usage the module needs to be loaded like so:
*   Flight::module()->load([ 'tigrez.slog', 'othermod1', 'other.etc']);
* This class can be registred to Flight like so:
*   Flight::register('logger','SLog', ['dir/to/log/in']);
* And can be addressed like so:
*   Flight::logger->write('take this!');
* 
* Please read the comments in the ModLoader class on how modules work in FC.
* 
* @author Tigrez/L.Geritz <coding@tigrez.nl>
*/
class Slog{
	private $path;
	
	/**
	* Write a log message.
	* The logfile is in the path as specified in contructor and has 
	* todays date as name suffixed with '.log'.
	* @param string $msg
	* 
	*/
	public function write($msg){
        $filehandle=fopen($this->path.date('Ymd').'.log',"a");
        flock($filehandle, LOCK_EX); 
        fwrite($filehandle,date("Ymd H:i:s").' '.$msg. chr(10));
        flock($filehandle, LOCK_UN); 
    	fclose($filehandle);
	}
	
	/**
	* Constructor.
	* If path is invalid you might end up with log files in your root
	* @param string $path path where logfiles are stored
	*/
	public function __construct($path){
		$this->path = realpath($path).DIRECTORY_SEPARATOR;
	}
	
}