<?php namespace Orchestra\Widget\Handlers\TestCase;

use Mockery as m;
use Illuminate\Support\Fluent;
use Orchestra\Support\Collection;
use Orchestra\Widget\Handlers\Menu;

class MenuTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test construct a Orchestra\Widget\Handlers\Menu
     *
     * @test
     */
    public function testConstructMethod()
    {
        $stub   = new Menu('foo', array());
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
     * Test Orchestra\Widget\Handlers\Menu::add() method.
     *
     * @test
     */
    public function testAddMethod()
    {
        $stub = new Menu('foo', array());

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

        $this->assertEquals($expected, $stub->items());
    }
}
