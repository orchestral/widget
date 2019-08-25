<?php

namespace Orchestra\Widget\TestCase\Feature;

use Orchestra\Support\Fluent;
use Orchestra\Support\Collection;
use Orchestra\Support\Facades\Widget;

class WidgetManagerTest extends TestCase
{
    /** @test */
    public function it_has_proper_signature()
    {
        $stub = $this->app->make('orchestra.widget');

        $this->assertInstanceOf('Orchestra\Widget\WidgetManager', $stub);
        $this->assertInstanceOf('Orchestra\Support\Manager', $stub);
        $this->assertInstanceOf('Illuminate\Support\Manager', $stub);
    }

    /** @test */
    public function it_can_be_extended()
    {
        Widget::extend('foo', function () {
            return 'foobar';
        });

        $this->assertEquals('foobar', Widget::make('foo'));
    }

    /** @test */
    public function it_can_make_menu()
    {
        config([
            'orchestra/widget::menu.foo' => [],
            'orchestra/widget::menu.foo.bar' => [],
        ]);

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Menu', Widget::make('menu.foo'));
        $this->assertInstanceOf('Orchestra\Widget\Handlers\Menu', Widget::make('menu.foo.bar'));
    }

    /** @test */
    public function it_can_make_pane()
    {
        config([
            'orchestra/widget::pane.foo' => [],
        ]);

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Pane', Widget::make('pane.foo'));
    }

    /** @test */
    public function testMakeMethodForPlaceholder()
    {
        config([
            'orchestra/widget::placeholder.foo' => [],
        ]);

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Placeholder', Widget::make('placeholder.foo'));
    }

    /** @test */
    public function it_can_make_based_on_default_driver()
    {
        config([
            'orchestra/widget::driver' => 'placeholder.default',
            'orchestra/widget::placeholder.default' => [],
        ]);

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Placeholder', Widget::driver());
    }

    /** @test */
    public function it_can_set_default_driver()
    {
        $this->assertNotSame('foo', Widget::getDefaultDriver());

        Widget::setDefaultDriver('foo');

        $this->assertSame('foo', Widget::getDefaultDriver());
    }

    /** @test */
    public function it_throws_exception_given_invalid_handler()
    {
        $this->expectException('InvalidArgumentException');

        Widget::make('foobar');
    }

    /** @test */
    public function it_can_get_item_using_of_helper()
    {
        config([
            'orchestra/widget::placeholder.foo' => [],
            'orchestra/widget::placeholder.default' => [],
            'orchestra/widget::driver' => 'placeholder.default',
        ]);

        $expected = new Collection([
            'foobar' => new Fluent([
                'id' => 'foobar',
                'value' => 'Hello world',
                'childs' => [],
            ]),
        ]);

        $stub1 = Widget::of('placeholder.foo', function ($p) {
            $p->add('foobar')->value('Hello world');
        });

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Placeholder', $stub1);
        $this->assertEquals($expected, $stub1->items());

        $stub2 = Widget::of(function ($p) {
            $p->add('foobar')->value('Hello world');
        });

        $this->assertInstanceOf('Orchestra\Widget\Handlers\Placeholder', $stub2);
        $this->assertEquals($expected, $stub2->items());
    }
}
