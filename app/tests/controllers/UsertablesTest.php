<?php

use Mockery as m;
use Way\Tests\Factory;

class UsertablesTest extends TestCase {

	public function __construct()
	{
		$this->mock = m::mock('Eloquent', 'UserTable');
		$this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

	public function setUp()
	{
		parent::setUp();

		$this->attributes = Factory::UserTable(['id' => 1]);
		$this->app->instance('UserTable', $this->mock);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testIndex()
	{
		$this->mock->shouldReceive('all')->once()->andReturn($this->collection);
		$this->call('GET', 'UserTables');

		$this->assertViewHas('UserTables');
	}

	public function testCreate()
	{
		$this->call('GET', 'UserTables/create');

		$this->assertResponseOk();
	}

	public function testStore()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(true);
		$this->call('POST', 'UserTables');

		$this->assertRedirectedToRoute('UserTables.index');
	}

	public function testStoreFails()
	{
		$this->mock->shouldReceive('create')->once();
		$this->validate(false);
		$this->call('POST', 'UserTables');

		$this->assertRedirectedToRoute('UserTables.create');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testShow()
	{
		$this->mock->shouldReceive('findOrFail')
				   ->with(1)
				   ->once()
				   ->andReturn($this->attributes);

		$this->call('GET', 'UserTables/1');

		$this->assertViewHas('UserTable');
	}

	public function testEdit()
	{
		$this->collection->id = 1;
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->once()
				   ->andReturn($this->collection);

		$this->call('GET', 'UserTables/1/edit');

		$this->assertViewHas('UserTable');
	}

	public function testUpdate()
	{
		$this->mock->shouldReceive('find')
				   ->with(1)
				   ->andReturn(m::mock(['update' => true]));

		$this->validate(true);
		$this->call('PATCH', 'UserTables/1');

		$this->assertRedirectedTo('UserTables/1');
	}

	public function testUpdateFails()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['update' => true]));
		$this->validate(false);
		$this->call('PATCH', 'UserTables/1');

		$this->assertRedirectedTo('UserTables/1/edit');
		$this->assertSessionHasErrors();
		$this->assertSessionHas('message');
	}

	public function testDestroy()
	{
		$this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['delete' => true]));

		$this->call('DELETE', 'UserTables/1');
	}

	protected function validate($bool)
	{
		Validator::shouldReceive('make')
				->once()
				->andReturn(m::mock(['passes' => $bool]));
	}
}
