<?php namespace Orchestra\Widget\TestCase;

use Mockery as m;
use Orchestra\Widget\MenuWidgetHandler;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class MenuWidgetHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\MenuWidgetHandler
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub   = new MenuWidgetHandler('foo', array());
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
                'icon'       => '',
                'link'       => '#',
                'title'      => '',
            ),
        );

        $this->assertEquals($expected, $config->getValue($stub));
        $this->assertEquals('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('menu', $type->getValue($stub));
    }

    /**
     * Test Orchestra\Widget\MenuWidgetHandler::add() method.
     *
     * @test
     */
    public function testAddMethod()
    {
        $stub = new MenuWidgetHandler('foo', array());

        $expected = new Collection(array(
            'foo' => new Fluent(array(
                'attributes' => array(),
                'childs'     => array(),
                'icon'       => '',
                'id'         => 'foo',
                'link'       => '#',
                'title'      => 'hello world',
            )),
            'foobar' => new Fluent(array(
                'attributes' => array(),
                'childs'     => array(),
                'icon'       => '',
                'id'         => 'foobar',
                'link'       => '#',
                'title'      => 'hello world 2',
            )),
        ));

        $stub->add('foo', function ($item) {
            $item->title = 'hello world';
        });

        $stub->add('foobar', '>:foo', function ($item) {
            $item->title = 'hello world 2';
        });

        $this->assertEquals($expected, $stub->getItems());
    }
}
