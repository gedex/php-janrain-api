<?php

namespace Janrain\Tests\HttpClient;

use Janrain\Client;
use Janrain\HttpClient\HttpClient;
use Janrain\HttpClient\Message\ResponseMediator;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Client as GuzzleClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function shouldBeAbleToPassOptionsToConstructor()
	{
		$httpClient = new TestHttpClient(array(
			'timeout' => 30
		), $this->getBrowserMock());

		$this->assertEquals(30, $httpClient->getOption('timeout'));
	}

	/**
	 * @test
	 */
	public function shouldBeAbleToSetOption()
	{
		$httpClient = new TestHttpClient(array(), $this->getBrowserMock());
		$httpClient->setOption('timeout', 5);

		$this->assertEquals(5, $httpClient->getOption('timeout'));
	}

	/**
	 * @test
	 */
	public function shouldDoGETRequest()
	{
		$path       = '/some/path';
		$parameters = array('a' => 'b');
		$headers    = array('c' => 'd');

		$client = $this->getBrowserMock();

		$httpClient = new HttpClient(array(), $client);
		$httpClient->get($path, $parameters, $headers);
	}

	/**
	 * @test
	 */
	public function shouldDoPOSTRequest()
	{
		$path = '/some/path';
		$body = 'a = b';
		$headers = array('c' => 'd');

		$client = $this->getBrowserMock();
		$client->expects($this->once())
			->method('createRequest')
			->with('POST', $path, $this->isType('array'), $body);

		$httpClient = new HttpClient(array(), $client);
		$httpClient->post($path, $body, $headers);
	}

	protected function getBrowserMock(array $methods = array())
	{
		$mock = $this->getMock(
			'Guzzle\Http\Client',
			array_merge(
				array('send', 'createRequest'),
				$methods
			)
		);

		$mock->expects($this->any())
			->method('createRequest')
			->will($this->returnValue($this->getMock('Guzzle\Http\Message\Request', array(), array('GET', 'some'))));

		return $mock;
	}
}

class TestHttpClient extends HttpClient
{
	public function getOption($name, $default = null)
	{
		return isset($this->options[$name]) ? $this->options[$name] : $default;
	}

	public function request($path, $body, $httpMethod = 'GET', array $headers = array(), array $options = array())
	{
		$request = $this->client->createRequest($httpMethod, $path);

		return $this->client->send($request);
	}
}
