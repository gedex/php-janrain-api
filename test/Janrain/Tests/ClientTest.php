<?php

namespace Janrain\Tests;

use Janrain\Client;
use Janrain\Exception\InvalidArgumentException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function shouldNotHaveToPassHttpClientToConstructor()
	{
		$client = new Client();

		$this->assertInstanceOf('Janrain\HttpClient\HttpClient', $client->getHttpClient());
	}

	/**
	 * @test
	 */
	public function shouldBeAbleToPassHttpClientInterfaceToConstructor()
	{
		$client = new Client($this->getHttpClientMock());

		$this->assertInstanceOf('Janrain\HttpClient\HttpClientInterface', $client->getHttpClient());
	}

	/**
	 * @test
	 * @dataProvider getDefaultClientOptionsData
	 */
	public function shouldNotHaveToPassOptionsToConstructor($options)
	{
		$client = new Client();

		foreach ($options as $option => $val) {
			$this->assertEquals($client->getOption($option), $val);
		}
	}

	public function getDefaultClientOptionsData()
	{
		return array(
			array( array(
				'base_url'      => 'https://example.com',
				'user_agent'    => 'php-janrain-api (https://github.com/gedex/php-janrain-api)',
				'timeout'       => 15,
				'access_token'  => '',
				'client_id'     => '',
				'client_secret' => ''
			) )
		);
	}

	public function getHttpClientMock(array $methods = array())
	{
		$methods = array_merge(
			array('get', 'post', 'request', 'setOption', 'setHeaders'),
			$methods
		);

		return $this->getMock('Janrain\HttpClient\HttpClientInterface', $methods);
	}
}
