<?php

namespace Janrain\Tests\Api;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
	abstract protected function getApiClass();

	protected function getApiMock()
	{
		$httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
		$httpClient
			->expects($this->any())
			->method('send');

		$mock = $this->getMock('Janrain\HttpClient\HttpClient', array(), array(array(), $httpClient));

		$client = new \Janrain\Client($mock);
		$client->setHttpClient($mock);

		return $this->getMockBuilder($this->getApiClass())
			->setMethods(array('post'))
			->setConstructorArgs(array($client))
			->getMock();
	}
}
