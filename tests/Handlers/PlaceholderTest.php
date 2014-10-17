<?php namespace Orchestra\Widget\Handlers\TestCase;

use Mockery as m;
use Illuminate\Support\Fluent;
use Orchestra\Support\Collection;
use Orchestra\Widget\Handlers\Placeholder;

class PlaceholderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Drivers\Handlers\Placeholder
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub = new Placeholder('foo', array());

        $refl   = new \ReflectionObject($stub);
        $config = $refl->getProperty('config');
        $name   = $refl->getProperty('name');
        $nesty  = $refl->getProperty('nesty');
        $type   = $refl->getProperty('type');

        $config->setAccessible(true);
        $name->setAccessible(true);
        $nesty->setAccessible(true);
        $type->setAccessible(true);

        $expected = array(
            'defaults' => array(
                'value' => '',
            ),
        );

        $this->assertEquals($expected, $config->getValue($stub));
        $this->assertEquals('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('placeholder', $type->getValue($stub));
    }

    /**
     * Test Orchestra\Widget\Handlers\Placeholder::add() method.
     *
     * @test
     */
    public function testAddMethod()
    {
        $stub = new Placeholder('foo', array());

        $callback = function () {
            return 'hello world';
        };

        $expected = new Collection(array(
            'foo' => new Fluent(array(
                'value'  => $callback,
                'id'     => 'foo',
                'childs' => array(),
            )),
            'foobar' => new Fluent(array(
                'value'  => $callback,
                'id'     => 'foobar',
                'childs' => array(),
            )),
            'hello' => new Fluent(array(
                'value'  => $callback,
                'id'     => 'hello',
                'childs' => array(),
            )),
        ));

        $stub->add('foo', $callback);
        $stub->add('foobar', '>:foo', $callback);
        $stub->add('hello', '^:foo', $callback);

        $this->assertEquals($expected, $stub->items());
    }
}
