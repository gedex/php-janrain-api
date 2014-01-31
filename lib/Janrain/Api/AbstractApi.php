<?php

namespace Janrain\Api;

use Janrain\Client;
use Janrain\HttpClient\Message\ResponseMediator;

/**
 * Abstract class for Api classes
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 */
abstract class AbstractApi
{
	/**
	 * The client
	 *
	 * @var Client
	 */
	protected $client;

	/**
	 * @param Client $client
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	/**
	 * Send a POST request with raw data.
	 *
	 * @param string $path Request path
	 * @param array $parameters Request body
	 */
	protected function post($path, $body = null, $requestHeaders = array())
	{
		$response = $this->client->getHttpClient()->post(
			$path,
			$body,
			$requestHeaders
		);

		return ResponseMediator::getContent($response);
	}
}
