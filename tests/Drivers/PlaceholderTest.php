<?php namespace Orchestra\Widget\Tests;

use Mockery as m;
use Orchestra\Widget\Drivers\Placeholder;
use Illuminate\Support\Fluent;

class PlaceholderTest extends \PHPUnit_Framework_TestCase {

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
	 * Test construct a Orchestra\Widget\Drivers\Placeholder
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::placeholder.foo", m::any())->andReturn(array());

		$stub = new Placeholder($app, 'foo');

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
	 * Test Orchestra\Widget\Menu::add() method.
	 *
	 * @test
	 */
	public function testAddMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::placeholder.foo", m::any())->andReturn(array());
		
		$stub = new Placeholder($app, 'foo');

		$callback = function ()
		{
			return 'hello world';
		};

		$expected = array(
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
		);

		$stub->add('foo', $callback);
		$stub->add('foobar', '>:foo', $callback);
		$stub->add('hello', '^:foo', $callback);

		$this->assertEquals($expected, $stub->getItems());
	}
}
