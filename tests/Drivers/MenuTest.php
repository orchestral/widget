<?php namespace Orchestra\Widget\Tests\Drivers;

class MenuTest extends \PHPUnit_Framework_TestCase {

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
	 * Test construct a Orchestra\Widget\Drivers\Menu
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::menu", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Drivers\Menu('foo', array());

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
				'title'      => '', 
				'link'       => '#', 
				'attributes' => array(),
			),
		);
		
		$this->assertEquals($expected, $config->getValue($stub));
		$this->assertEquals('foo', $name->getValue($stub));
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $nesty->getValue($stub));
		$this->assertEquals('menu', $type->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Drivers\Menu::add() method.
	 *
	 * @test
	 */
	public function testAddMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra/widget::menu", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Drivers\Menu('foo', array());

		$expected = array(
			'foo' => new \Illuminate\Support\Fluent(array(
				'title'      => 'hello world',
				'link'       => '#',
				'attributes' => array(),
				'id'         => 'foo',
				'childs'     => array(),
			)),
			'foobar' => new \Illuminate\Support\Fluent(array(
				'title'      => 'hello world 2',
				'link'       => '#',
				'attributes' => array(),
				'id'         => 'foobar',
				'childs'     => array(),
			)),
		);

		$stub->add('foo', function ($item)
		{
			$item->title = 'hello world';
		});

		$stub->add('foobar', 'after:foo', function ($item)
		{
			$item->title = 'hello world 2';
		});

		$this->assertEquals($expected, $stub->getItem());
	}
}