<?php namespace Orchestra\Widget\Tests\Drivers;

use Mockery as m;
use Orchestra\Widget\Drivers\Pane;
use Illuminate\Support\Fluent;

class PaneTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Application mock instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	private $app = null;

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$this->app = new \Illuminate\Container\Container;
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		unset($this->app);
		m::close();
	}

	/**
	 * Test construct a Orchestra\Widget\Drivers\Pane
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::pane.foo", m::any())->andReturn(array());
		
		$stub   = new Pane($app, 'foo');
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
	 * Test Orchestra\Widget\Menu::add() method.
	 *
	 * @test
	 */
	public function testAddMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::pane.foo", m::any())->andReturn(array());
		
		$stub = new Pane($app, 'foo');

		$expected = array(
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
		);

		$stub->add('foo', function ($item)
		{
			$item->content('hello world');
		});

		$stub->add('foobar', '>:foo', function ($item)
		{
			$item->title('hello world');
		});

		$this->assertEquals($expected, $stub->getItems());
	}
}
