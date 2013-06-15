<?php namespace Orchestra\Widget\Tests\Drivers;

use Mockery as m;
use Orchestra\Widget\Drivers\Menu;
use Illuminate\Support\Fluent;

class MenuTest extends \PHPUnit_Framework_TestCase {

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
	 * Test construct a Orchestra\Widget\Drivers\Menu
	 *
	 * @test
	 */
	public function testConstructMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::menu.foo", m::any())->andReturn(array());

		$stub   = new Menu($app, 'foo');
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
		$this->assertInstanceOf('\Orchestra\Support\Nesty', $nesty->getValue($stub));
		$this->assertEquals('menu', $type->getValue($stub));
	}

	/**
	 * Test Orchestra\Widget\Drivers\Menu::add() method.
	 *
	 * @test
	 */
	public function testAddMethod()
	{
		$app = $this->app;
		$app['config'] = $config = m::mock('Config');

		$config->shouldReceive('get')->once()
			->with("orchestra/widget::menu.foo", m::any())->andReturn(array());

		$stub = new Menu($app, 'foo');

		$expected = array(
			'foo' => new Fluent(array(
				'title'      => 'hello world',
				'link'       => '#',
				'attributes' => array(),
				'id'         => 'foo',
				'childs'     => array(),
			)),
			'foobar' => new Fluent(array(
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

		$stub->add('foobar', '>:foo', function ($item)
		{
			$item->title = 'hello world 2';
		});

		$this->assertEquals($expected, $stub->getItems());
	}
}
