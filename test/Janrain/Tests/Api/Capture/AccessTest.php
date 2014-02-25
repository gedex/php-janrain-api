<?php

namespace Janrain\Tests\Api\Capture;

use Janrain\Tests\Api\TestCase;

class AccessTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldGetAccessToken()
	{
		$expectedArray = array(
			'accessToken' => 'xxx',
			'stat'        => 'ok',
		);

		$params = array(
			'uuid'          => '1',
			'client_id'     => 'x',
			'client_secret' => 'y',
			'type_name'     => 'user',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('access/getAccessToken', $params)
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->getAccessToken($params));
	}

	/**
	 * @test
	 */
	public function shouldGetAuthorizationCode()
	{
		$expectedArray = array(
			'authorizationCode' => 'xxx',
			'stat'              => 'ok',
		);

		$params = array(
			'uuid'          => '1',
			'client_id'     => 'x',
			'client_secret' => 'y',
			'type_name'     => 'user',
		);

		$api = $this->getApiMock();
		$api->expects($this->once())
			->method('post')
			->with('access/getAuthorizationCode')
			->will($this->returnValue($expectedArray));

		$this->assertEquals($expectedArray, $api->getAuthorizationCode($params));
	}

	/**
	 * @test
	 */
	public function shouldGetAuthorizationCodeWithTransactionStateArgument()
	{

	}

	/**
	 * @test
	 */
	public function shouldGetCreationToken()
	{

	}

	/**
	 * @test
	 */
	public function shouldGetVerificationCode()
	{

	}

	/**
	 * @test
	 */
	public function shouldBeAbleToUseVerificationCode()
	{

	}

	protected function getApiClass()
	{
		return 'Janrain\Api\Capture\Access';
	}
}
