<?php namespace Orchestra\Widget\Tests\Drivers;

use Mockery as m;

class DriverTest extends \PHPUnit_Framework_TestCase {
	
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
	 * Test construct a Orchestra\Widget\Drivers\Driver
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')
			->with("orchestra/widget::stub.foo", m::any())->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);
		
		$stub = new DriverStub($this->app, 'foo');

		$refl   = new \ReflectionObject($stub);
		$config = $refl->getProperty('config');
		$name   = $refl->getProperty('name');
		$nesty  = $refl->getProperty('nesty');
		$type   = $refl->getProperty('type');

		$config->setAccessible(true);
		$name->setAccessible(true);
		$nesty->setAccessible(true);
		$type->setAccessible(true);

		$this->assertEquals(array(), $config->getValue($stub));
		$this->assertEquals('foo', $name->getValue($stub));
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $nesty->getValue($stub));
		$this->assertEquals('stub', $type->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Drivers\Driver::getItem() method.
	 *
	 * @test
	 */
	public function testGetItemMethod()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);

		$stub = new DriverStub($this->app, 'foo');

		$this->assertEquals(array(), $stub->getItem());
		$this->assertEquals(array(), $stub->items);
	}

	/**
	 * Test Orchestra\Widget\Drivers\Driver::__get() throws an exception.
	 *
	 * @expectedException \InvalidArgumentException
	 */
	public function testMagicMethodGetThrowsException()
	{
		$config = m::mock('Config');
		$config->shouldReceive('get')->once()->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($config);

		with(new DriverStub($this->app, 'foo'))->helloWorld;
	}
}

class DriverStub extends \Orchestra\Widget\Drivers\Driver {

	protected $type   = 'stub';
	protected $config = array();

	public function add($id, $location = 'parent', $callback = null)
	{
		$item = $this->nesty->add($id, $location ?: 'parent');

		if ($callback instanceof \Closure)
		{
			call_user_func($callback, $item);
		}

		return $item;
	}
}
