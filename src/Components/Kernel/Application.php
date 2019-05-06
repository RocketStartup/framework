<?php

namespace RocketStartup\Components\Kernel;

use Exception;

class Application
{   
    
    public $version;
    public $nameApplication = null;
    public $environment     = null;
    public $addressUri      = null;
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct()
    {
        return $this; 
    }


    public function generatorApp()
    {
        $generatorApps = \Http::getInstance(
            [
                'GeneratorApps',
                \RocketStartup\Components\Applications\ManagerApp\GeneratorApps::class
            ],
            \kernel::getInstance('Kernel')->getConfigurations('Applications')
        );

        if(is_null($generatorApps->getCurrentApplication()))
        { 
            throw new \Exception('Application not found.');
        }

        

        $this->nameApplication  = $generatorApps->getCurrentApplication()->nameApplication;
        $this->environment      = key($generatorApps->getCurrentApplication()->environmentApp);
        $this->version          = \Config::getInstance('ConfigFile')->Version;
        

        \Http::getInstance(
            [
                'LocationBroker',
                \RocketStartup\Components\Header\Location\LocationBroker::class
            ]
        )->AuthorizeLocation(
            $generatorApps->getCurrentApplication()->environmentApp
        );

        $orm = \Orm::getInstance(
            [
                'Orm',
                \RocketStartup\Components\DataBase\Orm::class
            ],
            $generatorApps->getCurrentApplication()->environmentApp
        );
        
        $app = \App::getInstance(
            [
                'instanceApplication',
                \RocketStartup\Components\Applications\instanceApplication::class
            ],
            $generatorApps->getCurrentApplication()
        );

        $this->addressUri = $app->addressUri; 

    }

    public function addressUri(){
        return $this->addressUri;
    }
    public function version(){
        return $this->version;
    }
}