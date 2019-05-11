<?php

namespace Astronphp\Components\DataBase;
		
class Orm{
	public $engine;
	public $host;
	public $username;
	public $password;
	public $database;
	public $port;

  	public function __construct(array $conf){
		$conf = current($conf);
		$this->engine		=	$conf->dataBase->engine		??	'mysql';
		$this->host			=	$conf->dataBase->host		??	null;
		$this->username		=	$conf->dataBase->username	??	null;
		$this->password		=	$conf->dataBase->password	??	null;
		$this->database		=	$conf->dataBase->database	??	null;
		$this->port			=	$conf->dataBase->port		??	'3306';
	}

	public function mysql(){
		if(class_exists(\Astronphp\Orm\MakerSql::class)){
			return \Orm::getInstance(
					[
						'mysql',
						\Astronphp\Orm\MakerSql::class
					]
				);
		}else{
			throw new \Exception("Use composer require astronphp/orm");
		}
	}

}