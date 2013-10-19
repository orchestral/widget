<?php namespace Orchestra\Widget\Tests\Drivers;

use Mockery as m;
use Illuminate\Support\Fluent;

class DriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Application mock instance.
     *
     * @var Illuminate\Foundation\Application
     */
    private $app = null;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $this->app = new \Illuminate\Container\Container;
    }

    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        unset($this->app);
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Drivers\Driver
     *
     * @test
     */
    public function testConstructMethod()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('Config');

        $config->shouldReceive('get')->once()
            ->with("orchestra/widget::stub.foo", m::any())->andReturn(array());

        $stub = new DriverStub($app, 'foo');

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
        $this->assertInstanceOf('\ArrayIterator', $stub->getIterator());
        $this->assertEquals(0, count($stub));
    }

    /**
     * Test Orchestra\Widget\Drivers\Driver::getItem() method.
     *
     * @test
     */
    public function testGetItemMethod()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('Config');

        $config->shouldReceive('get')->once()->andReturn(array());

        $stub = new DriverStub($app, 'foo');

        $this->assertEquals(array(), $stub->getItems());
        $this->assertEquals(array(), $stub->items);
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
        $app = $this->app;
        $app['config'] = $config = m::mock('Config');

        $config->shouldReceive('get')->once()->andReturn(array());

        with(new DriverStub($app, 'foo'))->helloWorld;
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
