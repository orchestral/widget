<?php namespace Orchestra\Widget\Handlers\TestCase;

use Mockery as m;
use Illuminate\Support\Fluent;
use Orchestra\Support\Collection;
use Orchestra\Widget\Handlers\Pane;

class PaneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Handlers\Pane
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub   = new Pane('foo', array());

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
                'attributes' => array(),
                'title'      => '',
                'content'    => '',
                'html'       => '',
            ),
        );

        $this->assertEquals($expected, $config->getValue($stub));
        $this->assertEquals('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('pane', $type->getValue($stub));
    }

    /**
     * Test Orchestra\Widget\Handlers\Pane::add() method.
     *
     * @test
     */
    public function testAddMethod()
    {
        $stub = new Pane('foo', array());

        $expected = new Collection(array(
            'foo' => new Fluent(array(
                'attributes' => array(),
                'title'      => '',
                'content'    => 'hello world',
                'html'       => '',
                'id'         => 'foo',
                'childs'     => array(),
            )),
            'foobar' => new Fluent(array(
                'attributes' => array(),
                'title'      => 'hello world',
                'content'    => '',
                'html'       => '',
                'id'         => 'foobar',
                'childs'     => array(),
            )),
            'hello' => new Fluent(array(
                'attributes' => array(),
                'title'      => 'hello world',
                'content'    => '',
                'html'       => '',
                'id'         => 'hello',
                'childs'     => array(),
            )),
        ));

        $callback = function ($item) {
            $item->title('hello world');
        };

        $stub->add('foo', function ($item) {
            $item->content('hello world');
        });

        $stub->add('foobar', '>:foo', $callback);

        $stub->add('hello', '^:foo', $callback);

        $this->assertEquals($expected, $stub->items());
    }
}
