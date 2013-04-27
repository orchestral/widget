<?php namespace Orchestra\Widget\Tests;

use Mockery as m;
use Orchestra\Widget\WidgetManager;

class WidgetManagerTest extends \PHPUnit_Framework_TestCase {

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
		$this->app->shouldReceive('instance')->andReturn(true);

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
	 * Test construct a new Orchestra\Widget\WidgetManager.
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$stub = new WidgetManager($this->app);

		$this->assertInstanceOf('\Orchestra\Widget\WidgetManager', $stub);
		$this->assertInstanceOf('\Orchestra\Support\Manager', $stub);
		$this->assertInstanceOf('\Illuminate\Support\Manager', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::extend() method.
	 *
	 * @test
	 */
	public function testExtendMethod()
	{
		$callback = function ()
		{
			return 'foobar';
		};

		$stub = new WidgetManager($this->app);
		$stub->extend('foo', $callback);

		$refl = new \ReflectionObject($stub);
		$customCreators = $refl->getProperty('customCreators');
		$customCreators->setAccessible(true);

		$this->assertEquals(array('foo' => $callback), $customCreators->getValue($stub));

		$output = $stub->make('foo');

		$this->assertEquals('foobar', $output);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method for menu.
	 *
	 * @test
	 */
	public function testMakeMethodForMenu()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')
			->with("orchestra/widget::menu.foo", m::any())->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);

		$stub = with(new WidgetManager($this->app))->make('menu.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Menu', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method for pane.
	 *
	 * @test
	 */
	public function testMakeMethodForPane()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')
			->with("orchestra/widget::pane.foo", m::any())->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);

		$stub = with(new WidgetManager($this->app))->make('pane.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Pane', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method for placeholder.
	 *
	 * @test
	 */
	public function testMakeMethodForPlaceholder()
	{
		$configMock = m::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder.foo", m::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\WidgetManager($this->app))->make('placeholder.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Placeholder', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() using default driver method.
	 *
	 * @test
	 */
	public function testMakeMethodForDefaultDriver()
	{
		$configMock = m::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder.default", m::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\WidgetManager($this->app))->driver();

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Placeholder', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method throws expection 
	 * for unknown widget type.
	 *
	 * @expectedException \InvalidArgumentException
	 */
	public function testMakeMethodThrowsException()
	{
		$stub = with(new \Orchestra\Widget\WidgetManager($this->app))->make('foobar');
	}
}
