<?php

namespace RocketStartup\Components\Http;

class Response{
	
	function __construct($code)
	{
		http_response_code($code);
	}
}
