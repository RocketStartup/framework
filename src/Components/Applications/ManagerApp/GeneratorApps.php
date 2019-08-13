<?php

namespace Astronphp\Components\Applications\ManagerApp;
use Astronphp\Components\Applications\ManagerApp\Applications;

class GeneratorApps{
	public $apps;
	public $currentApplication;

	public function __construct($objectJson){
		foreach ($objectJson as $nameApp => $environment) {
			$this->apps[] = new Applications($nameApp, $environment);
		}
		if(is_null($this->apps)){
			throw new \Exception('You need to set up an app on astronphp.json.');
		}else{
			return $this;
		}
	}

	public function getCurrentApplication(){
		$equals=$this->getCurrentApplicationEquals();
		if(is_null($equals)){
			$like=$this->getCurrentApplicationLike();
		}
		return $this->currentApplication;

	}

	private function getCurrentApplicationEquals(){
		$this->currentApplication=null;
		if(substr($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)=='/'){ 
			$server_uri = substr($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 0,-1); 
		}else{  
			$server_uri =  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		}

		foreach ($this->apps as $app) {
			foreach ($app->environmentApp as $configApp) {
				if(isset($configApp->addressUri)){
					if(substr($configApp->addressUri, -1)=='/'){ $appUri = substr($configApp->addressUri, 0,-1); }else{ $appUri = $configApp->addressUri; $configApp->addressUri.='/';}

					if(!empty($configApp->addressUri) && ($server_uri==$appUri || $_SERVER['HTTP_HOST']==$appUri)){ 
					        $configApp->active = true;                                                              
					        $app->active = true;                                                                    
					        $this->currentApplication = $app;                                                       
					        $this->currentApplication->environmentApp = array();                                    
					        $this->currentApplication->environmentApp[$configApp->environment]=$configApp;          
					        break;                                                                                  
					}                                                                                               
				}
			}
		}
		
		return $this->currentApplication;
		
	}

	private function getCurrentApplicationLike(){
		$this->currentApplication=null;
		if(substr($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], -1)=='/'){ $server_uri = substr($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 0,-1); }else{  $server_uri =  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; }

		foreach ($this->apps as $app) {
			foreach ($app->environmentApp as $configApp) {
				if(isset($configApp->addressUri)){
					if(substr($configApp->addressUri, -1)=='/'){ $appUri = substr($configApp->addressUri, 0,-1); }else{ $appUri = $configApp->addressUri; $configApp->addressUri.='/';}
					if(!empty($configApp->addressUri) && strpos($server_uri,$appUri)!==false){
						$configApp->active = true;
						$app->active = true;
						
						$this->currentApplication = $app;
						$this->currentApplication->environmentApp = array();
						$this->currentApplication->environmentApp[$configApp->environment]=$configApp;
									
					}
				}
			}
		}
		return $this->currentApplication;
	}



}