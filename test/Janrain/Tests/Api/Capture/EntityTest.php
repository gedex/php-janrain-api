<?php

namespace Janrain\Tests\Api\Capture;

use Janrain\Tests\Api\TestCase;

class EntityTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldViewEntityByUuid()
	{
		$expectedArray = array(
			'result' => array('uuid' => 1),
			'stat'   => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity', array('uuid' => '1', 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->view(1, array('type_name' => 'user')));
	}

	/**
	 * @test
	 */
	public function shouldViewEntityById()
	{
		$expectedArray = array(
			'result' => array('id' => 1),
			'stat'   => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity', array('id' => 1, 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->viewById(1, array('type_name' => 'user')));
	}

	/**
	 * @test
	 */
	public function shouldViewEntityByAttribute()
	{
		$expectedArray = array(
			'result' => array('id' => 1),
			'stat'   => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity', array('key_attribute' => 'email', 'key_value' => '"user@example.com"', 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->viewByAttribute('email', 'user@example.com', array('type_name' => 'user')));
	}

	/**
	 * @test
	 */
	public function shouldPostAttributesAsJsonEncodedString()
	{
		$expectedArray = array(
			'result' => array('uuid' => 1, 'displayName' => 'Akeda Bagus', 'email' => 'user@example.com'),
			'stat'   => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity', array(
				'uuid'       => '1',
				'type_name'  => 'user',
				'attributes' => '["uuid","displayName","email"]',
			))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->view(1, array(
			'type_name'  => 'user',
			'attributes' => array( 'uuid', 'displayName', 'email' ),
		)));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotViewEntityIfTypeNameIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->view(1, array());
	}

	/**
	 * @test
	 */
	public function shouldCountNumberOfEntities()
	{
		$expectedArray = array(
			'total_count' => 2,
			'stat'        => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.count', array(
				'type_name'  => 'user',
			))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->count('user'));
	}

	/**
	 * @test
	 */
	public function shouldCreateEntity()
	{
		$expectedArray = array(
			'id'   => 1,
			'uuid' => 'xxx',
			'stat' => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.create', array(
				'type_name'  => 'user',
				'attributes' => '{"firstName":"Akeda","lastName":"Bagus"}',
			))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->create(array(
			'type_name'  => 'user',
			'attributes' => array('firstName' => 'Akeda', 'lastName' => 'Bagus'),
		)));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotCreateEntityIfAttributesIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->create(array('type_name' => 'user'));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\InvalidArgumentException
	 */
	public function shouldNotCreateEntityIfAttributesIsNotArray()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->create(array('type_name' => 'user', 'attributes' => 'x'));
	}

	/**
	 * @test
	 */
	public function shouldBulkCreateEntities()
	{
		$expectedArray = array(
			'uuid_results' => array('x', 'y'),
			'stat'         => 'ok',
			'results'      => array(1, 2),
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.bulkCreate', array(
				'type_name'      => 'user',
				'all_attributes' => '[{"firstName":"a","lastName":"b"},{"firstName":"c","lastName":"d"}]',
			))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->bulkCreate(array(
			'type_name'      => 'user',
			'all_attributes' => array(
				array('firstName' => 'a', 'lastName' => 'b'),
				array('firstName' => 'c', 'lastName' => 'd'),
			),
		)));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotBulkCreateEntitiesIfAttributesIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->bulkCreate(array('type_name' => 'user'));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\InvalidArgumentException
	 */
	public function shouldNotBulkCreateEntityIfAttributesIsNotArray()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->bulkCreate(array('type_name' => 'user', 'all_attributes' => 'x'));
	}

	/**
	 * @test
	 */
	public function shouldDeleteEntityByUuid()
	{
		$expectedArray = array('stat' => 'ok',);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.delete', array('uuid' => 1, 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->delete(1, array('type_name' => 'user')));
	}

	/**
	 * @test
	 */
	public function shouldDeleteEntityById()
	{
		$expectedArray = array('stat' => 'ok',);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.delete', array('id' => 1, 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->deleteById(1, array('type_name' => 'user')));
	}

	/**
	 * @test
	 */
	public function shouldDeleteEntityByAttribute()
	{
		$expectedArray = array('stat' => 'ok',);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.delete', array('key_attribute' => 'email', 'key_value' => '"user@example.com"', 'type_name' => 'user'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->deleteByAttribute('email', 'user@example.com', array('type_name' => 'user')));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotDeleteEntityIfTypeNameIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->delete(1, array());
	}

	/**
	 * @test
	 */
	public function shouldBulkDeleteEntities()
	{
		$expectedArray = array('stat' => 'ok', 'delete_count' => 10);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('entity.bulkDelete', array('type_name' => 'user', 'filter' => 'email is not null'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->bulkDelete(array('type_name' => 'user', 'filter' => 'email is not null')));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotBulkDeleteEntitiesIfTypeNameIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->bulkDelete(array('filter' => 'email is not null'));
	}

	/**
	 * @test
	 * @expectedException Janrain\Exception\MissingArgumentException
	 */
	public function shouldNotBulkDeleteEntitiesIfFilterIsMissing()
	{
		$api = $this->getApiMock();
		$api->expects($this->never())
			->method('post');

		$api->bulkDelete(array('type_name' => 'user'));
	}

	protected function getApiClass()
	{
		return 'Janrain\Api\Capture\Entity';
	}
}
