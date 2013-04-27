<?php namespace Orchestra\Widget\Tests;

use Illuminate\Support\Fluent;
use Orchestra\Widget\Nesty;

class NestyTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Stub instance.
	 *
	 * @var Orchestra\Widget\Nesty
	 */
	private $stub = null;

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		$this->stub = new Nesty(array());
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		unset($this->stub);
	}

	/**
	 * Test instanceof stub.
	 *
	 * @test
	 * @group core
	 * @group widget
	 */
	public function testInstanceOfNesty()
	{
		$this->assertInstanceOf('\Orchestra\Widget\Nesty', $this->stub);

		$refl   = new \ReflectionObject($this->stub);
		$config = $refl->getProperty('config');
		$config->setAccessible(true);

		$this->assertEquals(array(), $config->getValue($this->stub));
	}

	/**
	 * Get newly instantiated Orchestra\Widget\Nesty::get() return empty
	 * string.
	 *
	 * @test
	 * @group core
	 * @group widget
	 */
	public function testNewInstanceReturnEmptyArray()
	{
		$this->assertEquals(array(),
			with(new Nesty(array()))->getItem());
	}

	/**
	 * Test adding an item to Orchestra\Widget\Nesty.
	 *
	 * @test
	 * @group core
	 * @group widget
	 */
	public function testAddMethod()
	{
		$expected = array(
			'hello' => new Fluent(array(
				'id'     => 'hello',
				'childs' => array(),
			)),
			'world' => new Fluent(array(
				'id'     => 'world',
				'childs' => array(),
			)),
			'foo' => new Fluent(array(
				'id'     => 'foo',
				'childs' => array(
					'bar' => new Fluent(array(
						'id'     => 'bar',
						'childs' => array(),
					)),
					'foobar' => new Fluent(array(
						'id'     => 'foobar',
						'childs' => array(
							'hello-foobar' => new Fluent(array(
								'id'     => 'hello-foobar',
								'childs' => array(),
							)),
						),
					)),
					'foo-bar' => new Fluent(array(
						'id'     => 'foo-bar',
						'childs' => array(),
					)),
					'hello-world-foobar' => new Fluent(array(
						'id'     => 'hello-world-foobar',
						'childs' => array(),
					)),
				),
			))
		);

		$this->stub->add('foo');
		$this->stub->add('hello', '<:foo');
		$this->stub->add('world', '>:hello');
		$this->stub->add('bar', '^:foo');
		$this->stub->add('foobar', '^:foo');
		$this->stub->add('foo-bar', '^:foo');
		$this->stub->add('hello-foobar', '^:foo.foobar');
		$this->stub->add('hello-world-foobar', '^:foo.dummy');

		$this->assertEquals($expected, $this->stub->getItem());
	}

	/**
	 * Test adding an item to Orchestra\Widget\Nesty when decendant is not
	 * presented.
	 *
	 * @test
	 * @group core
	 * @group widget
	 */
	public function testAddMethodWhenDecendantIsNotPresented()
	{
		$stub = new Nesty(array());

		$stub->add('foo', '^:home');
		$this->assertEquals(array(), $stub->getItem());
	}
}
