<?php

namespace Astronphp\Components\Header\Location;

class LocationBroker{

	
	public function AuthorizeLocation($objectApp){

		$objectApp = current($objectApp);
		$locationHref = $this->AuthorizeHttps($objectApp).$this->AuthorizeWww($objectApp);
		if(!empty($locationHref)){
			header('Location: '.$locationHref.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']); exit;
		}else{
			return false;
		}
	
	}

	private function AuthorizeHttps($objectApp){
		if(	
			(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && $objectApp->forceHttps==false) ||
			($objectApp->forceHttps==true && (!isset($_SERVER['HTTPS']) || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'off')))
		){
			return ($objectApp->forceHttps==false?'http://':'https://');
		}else{
			return '';
		}

	}

	private function AuthorizeWww($objectApp){
		if((preg_match('/^www/', $_SERVER['SERVER_NAME']) && $objectApp->forceWww==false) || (!preg_match('/^www/', $_SERVER['SERVER_NAME']) && $objectApp->forceWww==true) ){
           return ($objectApp->forceWww==true?'www.':'');
           
        }
	}
}