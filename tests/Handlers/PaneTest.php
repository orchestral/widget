<?php

namespace Orchestra\Widget\Handlers\TestCase;

use Mockery as m;
use Orchestra\Support\Fluent;
use PHPUnit\Framework\TestCase;
use Orchestra\Support\Collection;
use Orchestra\Widget\Handlers\Pane;

class PaneTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_be_constructed()
    {
        $stub = new Pane('foo', []);

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
            'defaults' => [
                'attributes' => [],
                'title' => '',
                'content' => '',
                'html' => '',
            ],
        ];

        $this->assertEquals($expected, $config->getValue($stub));
        $this->assertEquals('foo', $name->getValue($stub));
        $this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
        $this->assertEquals('pane', $type->getValue($stub));
    }

    /** @test */
    public function it_can_add_panes()
    {
        $stub = new Pane('foo', []);

        $expected = new Collection([
            'foo' => new Fluent([
                'attributes' => [],
                'title' => '',
                'content' => 'hello world',
                'html' => '',
                'id' => 'foo',
                'childs' => [],
            ]),
            'foobar' => new Fluent([
                'attributes' => [],
                'title' => 'hello world',
                'content' => '',
                'html' => '',
                'id' => 'foobar',
                'childs' => [],
            ]),
            'hello' => new Fluent([
                'attributes' => [],
                'title' => 'hello world',
                'content' => '',
                'html' => '',
                'id' => 'hello',
                'childs' => [],
            ]),
        ]);

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
