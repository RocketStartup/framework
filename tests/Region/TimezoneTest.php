<?php
use PHPUnit\Framework\TestCase;
use Astronphp\Components\Region\Timezone;

class TimezoneTest extends TestCase
{
    private $timezone;

    public function setUp()
    {
        $this->timezone = new Timezone([]);
    }

    /**
     * @use Timezone::setLocale
     * @use Timezone::setDateTimezone
     * @use Timezone::getLocale
     * @use Timezone::getDateTimezone
     */
    public function testRegister()
    {
        $config = ['locale'=>'en_US','date_timezone'=>'Los_Angeles'];
        $this->timezone = new Timezone($config);
        $this->assertEquals($config['locale'], $this->timezone->getLocale());
        $this->assertEquals($config['date_timezone'], $this->timezone->getDateTimezone());

        $config = ['locale'=>'pt-BR','date_timezone'=>'America/Sao_Paulo'];
        $this->timezone = new Timezone($config);
        $this->assertEquals($config['locale'], $this->timezone->getLocale());
        $this->assertEquals($config['date_timezone'], $this->timezone->getDateTimezone());

        
    }

    
    
    
    /**
     * @use Timezone::build
     * @use Timezone::defineLocale
     * @use Timezone::defineDateTimezone
     */
    public function testBuild()
    {
        $config = ['locale'=>'pt-BR','date_timezone'=>'America/Sao_Paulo'];
        $this->timezone = new Timezone($config);

        $this->assertEquals($config['locale'], $this->timezone->defineLocale());
        $this->assertEquals($config['date_timezone'], $this->timezone->defineDateTimezone());
        $this->assertTrue($this->timezone->build());
        
    }
}
