<?php

namespace RocketStartup\Components\Kernel;


class Foundation{
        
        public function __construct()
        {   
            ob_start();
            define('PATH_ROOT', explode('vendor/rocket-startup', __DIR__)[0]);

            $this->defineAlias();
            
            register_shutdown_function(function(){
                $this->terminate();
            });

            try {
                //Instance base system with low level settings
                \Kernel::getInstance([
                    'Kernel',
                    \RocketStartup\Components\Kernel\Kernel::class
                ]);                

                //Instance APP with configurations and controller
                \App::getInstance([
                    'App',
                    \RocketStartup\Components\Kernel\Application::class
                ])->generatorApp();

            } catch (\Exception $e) {
                \Errors::getInstance(
                    [   'ErrorView',
                        \RocketStartup\Components\ErrorReporting\ErrorView::class
                    ]
                )->setType('Framework')->setTitle('Foundation')->setExeption($e);
            }

        }

        public function defineAlias()
        {
            foreach ([
                'App'           =>   [\RocketStartup\Components\Support\App::class],
                'Config'        =>   [\RocketStartup\Components\Support\Config::class],
                'Kernel'        =>   [\RocketStartup\Components\Support\Kernel::class],
                'Errors'        =>   [\RocketStartup\Components\Support\Errors::class],
                'Sessions'      =>   [\RocketStartup\Components\Support\Sessions::class],
                'Http'          =>   [\RocketStartup\Components\Support\Http::class],
                'Orm'           =>   [\RocketStartup\Components\Support\Orm::class],
                'Performace'    =>   [\RocketStartup\Components\Support\Performace::class],
            ] as $key => $aliases) {
                foreach ($aliases as $alias) {
                    class_alias($alias,$key);
                }
            }
        }
        
        
        public function terminate() //will be called when php script ends.
        {

            if(!is_null(error_get_last())){
                \Errors::getInstance('ErrorsDefine')->errorHandler(error_get_last());
            }
            if(\Errors::getInstance('ErrorView')->hasError){
                ob_clean();
                \Errors::getInstance('ErrorView')->showError();
            }
            
            ob_flush();
            
        }

}