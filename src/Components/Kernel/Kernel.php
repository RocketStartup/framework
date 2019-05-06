<?php

namespace RocketStartup\Components\Kernel;


class Kernel{

     /**
     * The framework version.
     *
     * @var string
     */
    const VERSION = '0.0.2';
    
    /**
     * The base path for installation.
     *
     * @var string
     */
    protected $basePath;
     
    /**
     * The configurations for applications.
     *
     * @var string
     */
    protected $configurations = [];
    
    function __construct(){
          $this->getConfigurations();

          $this->ErrorDefine();

          $this->SessionServer();

          $this->Http();
     }

     /**
      * Get the version number of the framework.
      *
      * @return string
      */
     public function version()
     {
          return static::VERSION;
     }
     
     public function getConfigurations($key=null)
     {    
          $Config = \Config::getInstance([
               'ConfigFile',
               \RocketStartup\Components\Config\ConfigFile::class
          ]);

          $this->configurations = $Config->configurations;
          
          if(is_null($key)){
               return $this->configurations;
          }else{
               return $this->configurations[$key];
          }
     }

     public function ErrorDefine()
     {     
          if(isset($this->configurations['ErrorsDefine']))
          {
               \Errors::getInstance( 
                    [
                         'ErrorsDefine',
                         \RocketStartup\Components\ErrorReporting\ErrorsDefine::class,
                    ],
                    $this->configurations['ErrorsDefine']
               );

               \Errors::getInstance(
                    [   'ErrorView',
                        \RocketStartup\Components\ErrorReporting\ErrorView::class
                    ]
                );
          }
     }
    
     public function SessionServer()
     {    
          if(isset($this->configurations['Sessions']))
          {
               \Sessions::getInstance(
                    [
                         'SessionServer',
                         \RocketStartup\Components\Session\SessionServer::class,
                    ],
                    $this->configurations['Sessions']
               );
          }
     }

     public function Http()
     {    
          if(isset($this->configurations['Request']))
          {
               \Http::getInstance(
                    [
                         'SessionServer',
                         \RocketStartup\Components\Http\RequestLimiter::class,
                    ],
                    $this->configurations['Request']
               );
          }
          
     }
     
}
