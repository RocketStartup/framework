<?php

namespace RocketStartup\Components\Applications\ManagerApp;
use RocketStartup\Components\Applications\ManagerApp\EnvironmentApp;

class Applications{

	public $nameApplication;
	public $active = false;
	public $environmentApp;
	

	function __construct($nameApp, $environment){
		$this->nameApplication = $nameApp;
		foreach ($environment as $key => $value) {
			$this->environmentApp[$key] = new EnvironmentApp($key,$value);
		}

	}

}