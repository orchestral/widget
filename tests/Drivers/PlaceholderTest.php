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
		$this->app = m::mock('\Illuminate\Foundation\Application');
		$this->app->shouldReceive('instance')
				->andReturn(true);

		\Illuminate\Support\Facades\Config::setFacadeApplication($this->app);
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
		$config = m::mock('Config');
		$config->shouldReceive('get')
			->with("orchestra/widget::placeholder.foo", m::any())->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);
		
		$stub = new Placeholder($this->app, 'foo');

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
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $nesty->getValue($stub));
		$this->assertEquals('placeholder', $type->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Menu::add() method.
	 *
	 * @test
	 */
	public function testAddMethod()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')
			->with("orchestra/widget::placeholder.foo", m::any())->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);
		
		$stub = new Placeholder($this->app, 'foo');

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
		);

		$stub->add('foo', $callback);
		$stub->add('foobar', '>:foo', $callback);

		$this->assertEquals($expected, $stub->getItems());
	}
}
