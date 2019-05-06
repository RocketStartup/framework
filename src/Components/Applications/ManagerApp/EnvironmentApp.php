<?php

namespace RocketStartup\Components\Applications\ManagerApp;
use RocketStartup\Components\Applications\ManagerApp\EnvironmentDataBase; 

class EnvironmentApp{

	public $environment;
	public $active 		= false;
	public $addressUri	= '';
	public $forceHttps  = false;
	public $forceWww  	= false;
	public $dataBase	= false;


	function __construct($environment,$settings){
		$this->environment 	=	$environment  				??	null;
		$this->addressUri 	=	$settings['addressUri']  	??	null;
		$this->forceHttps 	=	$settings['forceHttps']  	??	null;
		$this->forceWww 	=	$settings['forceWww'] 		??	null;
		if(isset($settings['database'])){
			$this->dataBase 	=	new EnvironmentDataBase($settings['database']);
		}
	}
}