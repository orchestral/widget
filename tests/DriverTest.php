<?php namespace Orchestra\Widget\Tests;

class DriverTest extends \PHPUnit_Framework_TestCase {
	
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
	 * Test construct a Orchestra\Widget\Driver
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new DriverStub('foo', array());

		$refl   = new \ReflectionObject($stub);
		$config = $refl->getProperty('config');
		$name   = $refl->getProperty('name');
		$nesty  = $refl->getProperty('nesty');
		$type   = $refl->getProperty('type');

		$config->setAccessible(true);
		$name->setAccessible(true);
		$nesty->setAccessible(true);
		$type->setAccessible(true);

		$this->assertEquals(array(), 
			$config->getValue($stub));
		$this->assertEquals('foo', $name->getValue($stub));
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $nesty->getValue($stub));
		$this->assertEquals('stub', $type->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Driver::getItem() method.
	 *
	 * @test
	 */
	public function testGetItemMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = new DriverStub('foo', array());

		$this->assertEquals(array(), $stub->getItem());
		$this->assertEquals(array(), $stub->items);
	}

	/**
	 * Test Orchestra\Widget\Driver::__get() throws an exception.
	 *
	 * @expectedException \InvalidArgumentException
	 */
	public function testMagicMethodGetThrowsException()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());

		$stub = new DriverStub('foo', array());

		$stub->helloWorld;
	}
}

class DriverStub extends \Orchestra\Widget\Driver {

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