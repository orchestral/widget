<?php namespace Orchestra\Widget\Tests;

class PaneTest extends \PHPUnit_Framework_TestCase {

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
	 * Test construct a Orchestra\Widget\Pane
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$configMock = \Mockery::mock('Config')
			->shouldReceive('get')
			->with("orchestra::widget.pane", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Pane('foo', array());

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
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $nesty->getValue($stub));
		$this->assertEquals('pane', $type->getValue($stub));
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
			->with("orchestra::widget.pane", \Mockery::any())
			->once()
			->andReturn(array());

		\Illuminate\Support\Facades\Config::swap($configMock->getMock());
		
		$stub = new \Orchestra\Widget\Pane('foo', array());

		$expected = array(
			'foo' => new \Illuminate\Support\Fluent(array(
				'attributes' => array(),
				'title'      => '',
				'content'    => 'hello world',
				'html'       => '',
				'id'         => 'foo',
				'childs'     => array(),
			)),
			'foobar' => new \Illuminate\Support\Fluent(array(
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

		$stub->add('foobar', 'after:foo', function ($item)
		{
			$item->title('hello world');
		});

		$this->assertEquals($expected, $stub->getItem());
	}
}