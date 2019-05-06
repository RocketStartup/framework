<?php

namespace RocketStartup\Components\Applications\ManagerApp;
use RocketStartup\Components\Applications\ManagerApp\Applications;

class GeneratorApps{
	public $apps;
	public $currentApplication;

	public function __construct($objectJson){
		foreach ($objectJson as $nameApp => $environment) {
			$this->apps[] = new Applications($nameApp, $environment);
		}
		if(is_null($this->apps)){
			throw new \Exception('You need to set up an app on RocketStartup.json.');
		}else{
			return $this;
		}
	}

	public function getCurrentApplication(){
		foreach ($this->apps as $app) {
			foreach ($app->environmentApp as $configApp) {
				if(isset($configApp->addressUri)){
					if(!empty($configApp->addressUri) && strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] , $configApp->addressUri) !== false ){
						$configApp->active = true;
						$app->active = true;
						
						$this->currentApplication = $app;
						$this->currentApplication->environmentApp = array();
						$this->currentApplication->environmentApp[$configApp->environment]=$configApp;
									
						break 2;
					}
				}
			}
		}
		if(is_null($this->currentApplication)){
			throw new \Exception('Application not found, see addressUri on Leanstart.php');
		}else{
			return $this->currentApplication;
		}
	}



}