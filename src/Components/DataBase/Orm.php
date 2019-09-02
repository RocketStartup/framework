<?php

namespace Astronphp\Components\DataBase;
		
class Orm{
	public $engine;
	public $host;
	public $username;
	public $password;
	public $database;
	public $port;
	public $isDevMode;

  	public function __construct(\Astronphp\Components\Applications\ManagerApp\Applications $conf){
		
		$this->dirEntity		=	PATH_ROOT.'src/entity/'.$conf->nameApplication;
		$this->entityNamespace	=	ucfirst($conf->nameApplication);
		if(!\file_exists($this->dirEntity)){
			throw new \Exception("Create a folder for entity on ".$this->dirEntity);
		}
		$conf = current($conf->environmentApp);
		
		$this->engine		=	$conf->dataBase->engine		??	'pdo_mysql';
		$this->host			=	$conf->dataBase->host		??	null;
		$this->username		=	$conf->dataBase->username	??	null;
		$this->password		=	$conf->dataBase->password	??	null;
		$this->database		=	$conf->dataBase->database	??	null;
		$this->port			=	$conf->dataBase->port		??	'3306';
		$this->isDevMode	=	($conf->environment=='production'?false:true);
	}
	
	public function doctrine(){
		if(class_exists(\Astronphp\Orm\ConnectDoctrine::class)){
				return \Orm::getInstance(
					[
						'Doctrine',
						\Astronphp\Orm\ConnectDoctrine::class
					]
				);
		}else{
			throw new \Exception("Use composer require astronphp/orm");
		}
	}
}