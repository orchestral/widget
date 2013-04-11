<?php namespace Orchestra\Widget\Tests;

class PlaceholderTest extends \PHPUnit_Framework_TestCase {

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
	 * Test construct a Orchestra\Widget\Drivers\Placeholder
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Drivers\Placeholder('foo', array());

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
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::placeholder", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Drivers\Placeholder('foo', array());

		$callback = function ()
		{
			return 'hello world';
		};

		$expected = array(
			'foo' => new \Illuminate\Support\Fluent(array(
				'value'  => $callback,
				'id'     => 'foo',
				'childs' => array(),
			)),
			'foobar' => new \Illuminate\Support\Fluent(array(
				'value'  => $callback,
				'id'     => 'foobar',
				'childs' => array(),
			)),
		);

		$stub->add('foo', $callback);

		$stub->add('foobar', 'after:foo', $callback);

		$this->assertEquals($expected, $stub->getItem());
	}
}