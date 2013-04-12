<?php namespace Orchestra\Widget\Tests;

class WidgetManagerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Application mock instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected $app = null;

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$this->app = \Mockery::mock('\Illuminate\Foundation\Application');
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
		\Mockery::close();
	}

	/**
	 * Test construct a new Orchestra\Widget\WidgetManager.
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$stub = new \Orchestra\Widget\WidgetManager($this->app);

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

		$stub = new \Orchestra\Widget\WidgetManager($this->app);
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
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::menu.foo", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\WidgetManager($this->app))->make('menu.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Menu', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method for pane.
	 *
	 * @test
	 */
	public function testMakeMethodForPane()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::pane.foo", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\WidgetManager($this->app))->make('pane.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Drivers\Pane', $stub);
	}

	/**
	 * Test Orchestra\Widget\WidgetManager::make() method for placeholder.
	 *
	 * @test
	 */
	public function testMakeMethodForPlaceholder()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder.foo", \Mockery::any())
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
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder.default", \Mockery::any())
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