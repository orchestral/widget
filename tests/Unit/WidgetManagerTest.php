<?php

namespace Orchestra\Widget\TestCase\Unit;

use Mockery as m;
use Orchestra\Support\Fluent;
use PHPUnit\Framework\TestCase;
use Orchestra\Support\Collection;
use Illuminate\Container\Container;
use Orchestra\Widget\WidgetManager;

class WidgetManagerTest extends TestCase
{
    /**
     * Application mock instance.
     *
     * @var Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->app = new Container();
    }

    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        unset($this->app);
        m::close();
    }

    /** @test */
    public function it_has_proper_signature()
    {
        $stub = new WidgetManager($this->app);

        $this->assertInstanceOf('\Orchestra\Widget\WidgetManager', $stub);
        $this->assertInstanceOf('\Orchestra\Support\Manager', $stub);
        $this->assertInstanceOf('\Illuminate\Support\Manager', $stub);
    }

    /** @test */
    public function it_can_make_menu()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('get')->once()
                ->with('orchestra/widget::menu.foo', m::any())->andReturn([])
            ->shouldReceive('get')->once()
                ->with('orchestra/widget::menu.foo.bar', m::any())->andReturn([]);

        $stub1 = with(new WidgetManager($app))->make('menu.foo');

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Menu', $stub1);

        $stub2 = with(new WidgetManager($app))->make('menu.foo.bar');

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Menu', $stub2);
    }

    /** @test */
    public function it_can_make_pane()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('get')->once()
            ->with('orchestra/widget::pane.foo', m::any())->andReturn([]);

        $stub = with(new WidgetManager($app))->make('pane.foo');

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Pane', $stub);
    }

    /**
     * Test Orchestra\Widget\WidgetManager::make() method for placeholder.
     *
     * @test
     */
    public function testMakeMethodForPlaceholder()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('get')->once()
            ->with('orchestra/widget::placeholder.foo', m::any())->andReturn([]);

        $stub = with(new WidgetManager($app))->make('placeholder.foo');

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Placeholder', $stub);
    }

    /** @test */
    public function it_can_make_based_on_default_driver()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('get')->once()
                ->with('orchestra/widget::driver', 'placeholder.default')->andReturn('placeholder.default')
            ->shouldReceive('get')->once()
                ->with('orchestra/widget::placeholder.default', m::any())->andReturn([]);

        $stub = with(new WidgetManager($app))->driver();

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Placeholder', $stub);
    }

    /**
     * @rest
     */
    public function it_can_set_default_driver()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('set')->once()
                ->with('orchestra/widget::driver', 'foo')->andReturnNull();

        $stub = new WidgetManager($app);
        $stub->setDefaultDriver('foo');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_given_invalid_handler()
    {
        with(new WidgetManager($this->app))->make('foobar');
    }

    /** @test */
    public function it_can_get_item_using_of_helper()
    {
        $app = $this->app;
        $app['config'] = $config = m::mock('\Illuminate\Config\Repository');

        $config->shouldReceive('get')->once()
                ->with('orchestra/widget::placeholder.foo', m::any())->andReturn([])
            ->shouldReceive('get')->once()
                ->with('orchestra/widget::placeholder.default', m::any())->andReturn([])
            ->shouldReceive('get')->once()
                ->with('orchestra/widget::driver', 'placeholder.default')->andReturn('placeholder.default');

        $expected = new Collection([
            'foobar' => new Fluent([
                'id' => 'foobar',
                'value' => 'Hello world',
                'childs' => [],
            ]),
        ]);

        $stub1 = with(new WidgetManager($app))->of('placeholder.foo', function ($p) {
            $p->add('foobar')->value('Hello world');
        });

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Placeholder', $stub1);
        $this->assertEquals($expected, $stub1->items());

        $stub2 = with(new WidgetManager($app))->of(function ($p) {
            $p->add('foobar')->value('Hello world');
        });

        $this->assertInstanceOf('\Orchestra\Widget\Handlers\Placeholder', $stub2);
        $this->assertEquals($expected, $stub2->items());
    }
}
