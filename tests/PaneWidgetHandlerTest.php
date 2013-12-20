<?php namespace Orchestra\Widget\TestCase;

use Mockery as m;
use Orchestra\Widget\PaneWidgetHandler;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class PaneWidgetHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\PaneWidgetHandler
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub   = new PaneWidgetHandler('foo', array());

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
     * Test Orchestra\Widget\PaneWidgetHandler::add() method.
     *
     * @test
     */
    public function testAddMethod()
    {
        $stub = new PaneWidgetHandler('foo', array());

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

        $this->assertEquals($expected, $stub->getItems());
    }
}
