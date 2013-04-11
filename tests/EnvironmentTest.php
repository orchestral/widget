<?php namespace Orchestra\Widget\Tests;

class EnvironmentTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$appMock = \Mockery::mock('Application')
			->shouldReceive('instance')->andReturn(true);

		\Illuminate\Support\Facades\Config::setFacadeApplication($appMock->getMock());
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		\Mockery::close();
	}

	/**
	 * Test construct a new Orchestra\Widget\Environment.
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$stub = new \Orchestra\Widget\Environment;

		$refl      = new \ReflectionObject($stub);
		$registrar = $refl->getProperty('registrar');
		$instances = $refl->getProperty('instances');

		$registrar->setAccessible(true);
		$instances->setAccessible(true);

		$this->assertEquals(array(), $registrar->getValue($stub));
		$this->assertEquals(array(), $instances->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Environment::extend() method.
	 *
	 * @test
	 */
	public function testExtendMethod()
	{
		$callback = function ()
		{
			return 'foobar';
		};

		$stub = new \Orchestra\Widget\Environment;
		$stub->extend('foo', $callback);

		$refl      = new \ReflectionObject($stub);
		$registrar = $refl->getProperty('registrar');
		$instances = $refl->getProperty('instances');

		$registrar->setAccessible(true);
		$instances->setAccessible(true);

		$this->assertEquals(array('foo' => $callback), $registrar->getValue($stub));

		$output = $stub->make('foo');

		$this->assertEquals('foobar', $output);
		$this->assertEquals(array('foo.default' => 'foobar'), $instances->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Environment::make() method for menu.
	 *
	 * @test
	 */
	public function testMakeMethodForMenu()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::menu", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\Environment)->make('menu.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Menu', $stub);
	}

	/**
	 * Test Orchestra\Widget\Environment::make() method for pane.
	 *
	 * @test
	 */
	public function testMakeMethodForPane()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::pane", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\Environment)->make('pane.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Pane', $stub);
	}

	/**
	 * Test Orchestra\Widget\Environment::make() method for placeholder.
	 *
	 * @test
	 */
	public function testMakeMethodForPlaceholder()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = with(new \Orchestra\Widget\Environment)->make('placeholder.foo');

		$this->assertInstanceOf('\Orchestra\Widget\Placeholder', $stub);
	}

	/**
	 * Test Orchestra\Widget\Environment::make() method throws expection 
	 * for unknown widget type.
	 *
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function testMakeMethodThrowsException()
	{
		$stub = with(new \Orchestra\Widget\Environment)->make('foobar');
	}
}