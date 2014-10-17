<?php namespace Orchestra\Widget\TestCase;

use Closure;
use Mockery as m;
use Orchestra\Widget\Handler;
use Illuminate\Support\Fluent;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Handler
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub = new HandlerStub('foo', array());

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
        $this->assertInstanceOf('\Orchestra\Support\Collection', $stub->getIterator());
        $this->assertEquals(0, count($stub));
    }

    /**
     * Test Orchestra\Widget\Handler::items() method.
     *
     * @test
     */
    public function testItemsMethod()
    {
        $stub = new HandlerStub('foo', array());

        $this->assertInstanceOf('\Orchestra\Support\Collection', $stub->items());
        $this->assertNull($stub->is('foo'));

        $stub->add('foobar')->hello('world');
        $expected = new Fluent(array(
            'id'     => 'foobar',
            'hello'  => 'world',
            'childs' => array(),
        ));

        $this->assertEquals($expected, $stub->is('foobar'));
    }
}

class HandlerStub extends Handler
{
    protected $type   = 'stub';
    protected $config = array();

    public function add($id, $location = 'parent', $callback = null)
    {
        $item = $this->nesty->add($id, $location ?: 'parent');

        if ($callback instanceof Closure) {
            call_user_func($callback, $item);
        }

        return $item;
    }
}
