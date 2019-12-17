<?php

namespace Astronphp\Components\Performance;

class Timer
{
    /**
     * var log is arrat that stores all register
     * @var array
    */
    private $log = [];

    public function __construct()
    {
    }

    /**
     * register is method that opens and closes the timer count
     *
     * @param  mixed $name
     * @param  mixed $time
     * @param  mixed $description
     *
     * @return void
     */
    public function register($name=null, $time=null, $description=null)
    {
        if (is_null($name)) {
            return $name;
        }

        $register = $this->getOpen($name);
        
        if (is_bool($register)) {
            $this->open($name, $time, $description);
        } else {
            $key=$register;
            $this->close($name, $key, $time);
        }
        return $this;
    }

    /**
     * open new register
     *
     * @param  mixed $name
     * @param  mixed $time
     * @param  mixed $description
     *
     * @return void
     */
    public function open(string $name, $time=null, string $description=null)
    {
        $this->log[$name][] = array(
            'description' 	=> $description,
            'start' 		=> (is_null($time)?microtime(true):$time),
            'end' 			=> null,
            'time' 			=> null,
        );
        return $this->get($name);
    }
    
    /**
     * close
     *
     * @param  mixed $name
     * @param  mixed $key
     * @param  mixed $time
     *
     * @return void
     */
    public function close(string $name, int $key, $time=null)
    {
        if (is_null($this->get($name))) {
            return false;
        }
        if (is_null($time)) {
            $time = microtime(true);
        }
        $this->log[$name][$key]['end'] = $time;
        $this->log[$name][$key]['time'] = round(($time-$this->log[$name][$key]['start'])*1000, 0);
        
        return $this;
    }
    
    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function getOpen(string $name)
    {
        if (isset($this->log[$name])) {
            foreach ($this->log[$name] as $key => $value) {
                if ($value['end'] == null) {
                    return $key;
                }
            }
        }
        return false;
    }
    
    /**
     * function get return position of refister log
     *
     * @param string $name
     * @return void
     */
    public function get(string $name='')
    {
        if (isset($this->log[$name])) {
            return $this->log[$name];
        } else {
            return null;
        }
    }
}
