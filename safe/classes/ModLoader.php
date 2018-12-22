<?php
class ModLoader{
	
	const DepFile = 'dep.php';
	const SurpressChar = '~';
     
	private $modpath;
	private $callback;
	private $dirs = [];

	/**
	* Constructor 
	* @param string $path base path for modules
	* @param string $registerCallback function to call for each module to register the module. See load()
	*/	
	public function __construct($path, $registerCallback){
		$this->modpath = realpath($path);
		if(!$this->modpath){
			throw new Exception("modpath '$path' does not exist");
		}
		$this->modpath.=DIRECTORY_SEPARATOR;
		$this->callback = $registerCallback;
	}
	
	/**
	* Load modules.
	* 
	* Modules are passed as an array of strings. In the module name dots are replaced by slashes
	* and prefixed by  the modpath (as set in the constructor) it should be a valid path. E.g if
	* modpath = 'safe/modules' and module name  is Base.Logging then classes are expected in the
	* dir safe/modules/Base/Logging
	* 
	* This module dir is  passed to  registerCallback (as set in the  constructor) which has the 
	* responsibility  to assure classes in this dir can be found. Typically it adds the dir to a 
	* autoloader.
	* 
	* Supress callback
	* ----------------
	* To surpress calling the registerCallback, e.g. because there is already another mechanism
	* in place that assures the classes can be found let the module name start with ~. This ~ is
	* not used to create the corresponding folder name. The only reason I can think of for still
	* including a module like this in your module list is when it depends on other modules which
	* do need to be registred by the ModLoader, see next paragraph 
	* 
	* Dependencies
	* ------------
	* In the module folder you can place a dep.php file which should return an array with 
	* module names. These modules are loaded as well. Modules are only registred once, circulair 
	* dependencies do not lead to errors.  
	*   
	* @param array of string $mods 
	*/
	public function load(array $mods){
		
		foreach($mods as $mod){
			
			$doReg = !($mod[0]==self::SurpressChar);
			if(!$doReg){
				$mod = substr($mod,1);
			}
			
			if(!in_array($mod,$this->dirs)){
				
				$this->dirs[] = $mod;
				
				$dir = realpath($this->modpath . str_replace('.',DIRECTORY_SEPARATOR,$mod));
				if(!$dir){
					throw new Exception("module '$mod' does not exist");
				}
				if($doReg){
					$fun = $this->callback;
					$fun($dir);
				}
				$depfile = $dir . DIRECTORY_SEPARATOR . self::DepFile;
				if(file_exists($depfile)){
					$deps = include($depfile);
					if(is_array($deps)){
						$this->load($deps);	
					}
					else{
						throw new Exception("depfile '$depfile' does not return array");
					}
				}
			}
		}		
	}
}