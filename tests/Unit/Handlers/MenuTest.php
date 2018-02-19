<?php

namespace Orchestra\Widget\TestCase\Unit\Handlers;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Orchestra\Support\Collection;
use Orchestra\Widget\Handlers\Menu;
use Orchestra\Widget\Fluent\Menu as Fluent;

class MenuTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_can_be_constructed()
    {
        $stub = new Menu('foo', []);
        $refl = new \ReflectionObject($stub);
        $config = $refl->getProperty('config');
        $name = $refl->getProperty('name');
        $nesty = $refl->getProperty('nesty');
        $type = $refl->getProperty('type');

        $config->setAccessible(true);
        $name->setAccessible(true);
        $nesty->setAccessible(true);
        $type->setAccessible(true);

        $expected = [
            'fluent' => Fluent::class,
            'defaults' => [
                'icon' => '',
                'link' => '#',
                'title' => '',
                'handles' => null,
            ],
        ];

        $this->assertSame($expected, $config->getValue($stub));
        $this->assertSame('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('menu', $type->getValue($stub));
    }

    /** @test */
    public function it_can_add_menus()
    {
        $stub = new Menu('foo', []);

        $expected = new Collection([
            'foo' => new Fluent([
                'childs' => [],
                'icon' => '',
                'id' => 'foo',
                'link' => '#',
                'title' => 'hello world',
                'handles' => null,
            ]),
            'foobar' => new Fluent([
                'childs' => [],
                'icon' => '',
                'id' => 'foobar',
                'link' => '#',
                'title' => 'hello world 2',
                'handles' => null,
            ]),
        ]);

        $stub->add('foo', function ($item) {
            $item->title = 'hello world';
        });

        $stub->add('foobar', '>:foo', function ($item) {
            $item->title = 'hello world 2';
        });

        $this->assertEquals($expected, $stub->items());
    }
}
