<?php namespace Orchestra\Widget\Tests\Drivers;

use Mockery as m;
use Illuminate\Support\Fluent;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Drivers\Driver
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub = new DriverStub('foo', array());

        $refl   = new \ReflectionObject($stub);
        $config = $refl->getProperty('config');
        $name   = $refl->getProperty('name');
        $nesty  = $refl->getProperty('nesty');
        $type   = $refl->getProperty('type');

        $config->setAccessible(true);
        $name->setAccessible(true);
        $nesty->setAccessible(true);
        $type->setAccessible(true);

        $this->assertEquals(array(), $config->getValue($stub));
        $this->assertEquals('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('stub', $type->getValue($stub));
        $this->assertInstanceOf('\Illuminate\Support\Collection', $stub->getIterator());
        $this->assertEquals(0, count($stub));
    }

    /**
     * Test Orchestra\Widget\Drivers\Driver::getItem() method.
     *
     * @test
     */
    public function testGetItemMethod()
    {
        $stub = new DriverStub('foo', array());

        $this->assertInstanceOf('\Illuminate\Support\Collection', $stub->getItems());
        $this->assertInstanceOf('\Illuminate\Support\Collection', $stub->items);
        $this->assertNull($stub->is('foo'));

        $stub->add('foobar')->hello('world');
        $expected = new Fluent(array(
            'id'     => 'foobar',
            'hello'  => 'world',
            'childs' => array(),
        ));

        $this->assertEquals($expected, $stub->is('foobar'));
    }

    /**
     * Test Orchestra\Widget\Drivers\Driver::__get() throws an exception.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testMagicMethodGetThrowsException()
    {
        with(new DriverStub('foo', array()))->helloWorld;
    }
}

class DriverStub extends \Orchestra\Widget\Drivers\Driver
{
    protected $type   = 'stub';
    protected $config = array();

    public function add($id, $location = 'parent', $callback = null)
    {
        $item = $this->nesty->add($id, $location ?: 'parent');

        if ($callback instanceof \Closure) {
            call_user_func($callback, $item);
        }

        return $item;
    }
}
