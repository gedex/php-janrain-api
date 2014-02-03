<?php

namespace Janrain\Tests\Api;

use Janrain\Api\AbstractApi;
use Guzzle\Http\Message\Response;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function shouldPassPOSTRequestToClient()
	{
		$expectedArray = array('value');

		$httpClient = $this->getHttpMock();
		$httpClient
			->expects($this->once())
			->method('post')
			->with('/path', array('param1' => 'param1value'))
			->will($this->returnValue($expectedArray));

		$client = $this->getClientMock();
		$client->setHttpClient($httpClient);

		$api = $this->getAbstractApiObject($client);

		$this->assertEquals($expectedArray, $api->post('/path', array('param1' => 'param1value')));
	}

	protected function getAbstractApiObject($client)
	{
		return new AbstractApiTestInstance($client);
	}

	/**
	 * @return \Janrain\Client
	 */
	protected function getClientMock()
	{
		return new \Janrain\Client($this->getHttpMock());
	}

	/**
	 * @return \Janrain\HttpClient\HttpClientInterface
	 */
	protected function getHttpMOck()
	{
		return $this->getMock('Janrain\HttpClient\HttpClient', array(), array(array(), $this->getHttpClientMock()));
	}

	protected function getHttpClientMock()
	{
		$mock = $this->getMock('Guzzle\Http\Client', array('send'));
		$mock->expects($this->any())->method('send');

		return $mock;
	}
}

class AbstractApiTestInstance extends AbstractApi
{
	/**
	 * {@inheritDoc}
	 */
	public function post($path, $body = null, $requestHeaders = array())
	{
		return $this->client->getHttpClient()->post($path, $body, $requestHeaders);
	}
}
