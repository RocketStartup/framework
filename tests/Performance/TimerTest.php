<?php
use PHPUnit\Framework\TestCase;
use Astronphp\Components\Performance\Timer;

class TimerTest extends TestCase
{
    private $timer;
    
    public function setUp()
    {
        $this->timer = new Timer();
    }

    public function testRegister()
    {
        $this->assertEquals(null, $this->timer->register());
        
        $microtime = microtime(true);
        $key = $this->timer->register('test', $microtime)->getOpen('test');
        $this->assertEquals(0, $key);
        
        $this->assertFalse($this->timer->register('test')->getOpen('test'));
    }

    public function testOpen()
    {
        $microtime = microtime(true);
        $testArray = array(0 => [
            'description' 	=> 'My Comment',
            'start' 		=> $microtime,
            'end' 			=> null,
            'time' 			=> null
        ]);
        $object = $this->timer->open('test', $microtime, 'My Comment');
        $this->assertEquals($testArray, $object);
    }
    
    public function testGetOpen()
    {
        $this->timer->open('test', microtime(true), 'My Comment');
        $this->assertInternalType('int', $this->timer->getOpen('test'));
        $this->assertFalse($this->timer->getOpen('name'));
        $this->assertFalse($this->timer->getOpen('noname'));
    }

    public function testGet()
    {
        $this->assertInternalType('array', $this->timer->open('test'));
        $this->assertEquals(null, $this->timer->get('keynotfound'));
    }

    public function testClose()
    {
        $this->assertFalse($this->timer->close('notfound', 0));

        $this->timer->open('test', microtime(true), 'My Comment');
        $key = $this->timer->getOpen('test');
        $this->timer->close('test', $key);

        $this->assertFalse($this->timer->getOpen('test'));
    }
}
