<?php

namespace Janrain\Tests\Api\Capture;

use Janrain\Tests\Api\TestCase;

class VersionsTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldRetrievePastValueOfEntityByIdAndTimestamp()
	{
		$expectedArray = array(
			'result' => array('id' => 1),
			'stat'   => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('versions/entity', array('type_name' => 'user', 'timestamp' => 'yesterday', 'id' => 1))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->entity('user', 1, 'yesterday'));
	}

	/**
	 * @test
	 */
	public function shouldRetrievePastSchemaOfEntityTypeByTimestamp()
	{
		$expectedArray = array(
			'schema' => array(
				'name'      => 'user',
				'attr_defs' => array(
					array('name' => 'id', 'type' => 'id'),
				)
			),
			'stat' => 'ok',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('versions/entityType', array('type_name' => 'user', 'timestamp' => 'yesterday'))
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->entityType('user', 'yesterday'));
	}

	protected function getApiClass()
	{
		return 'Janrain\Api\Capture\Versions';
	}
}
