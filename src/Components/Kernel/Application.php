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


    public function generatorApps(){
        $generatorApps = \Http::getInstance(
            [
                'GeneratorApps',
                \RocketStartup\Components\Applications\ManagerApp\GeneratorApps::class
            ],
            \kernel::getInstance('Kernel')->getConfigurations('Applications')
        );
        return $generatorApps;
    }
    public function generatorApp()
    {
        $generatorApps=$this->generatorApps();

        if( 
            is_null($generatorApps->getCurrentApplication()) &&
            isset(\kernel::getInstance('Kernel')->getConfigurations('Applications')['main']['development']['addressUri']) &&
            empty(\kernel::getInstance('Kernel')->getConfigurations('Applications')['main']['development']['addressUri'])
        )
        { 
            // if dont found link, write on json the actual address
            $writeonJson = new \RocketStartup\Components\Config\UpdateConfigFile();
            $writeonJson->setConfigUriDev();

            // claen GeneratorApps and File of config
            \Http::unsetInstance('GeneratorApps');
            \Config::unsetInstance('ConfigFile');

            // reset config json and register \kernel::getInstance('Kernel')
            \kernel::getInstance('Kernel')->getConfigurations('Applications');

            $generatorApps=$this->generatorApps();

        }

        if(is_null($generatorApps->getCurrentApplication()))
        { 
            throw new \Exception('Application:'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].' not found in rocketstartup.json');
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