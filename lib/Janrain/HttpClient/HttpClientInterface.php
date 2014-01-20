<?php

namespace Janrain\HttpClient;

use Janrain\Exception\InvalidArgumentException;

/**
 * Performs requests on Janrain API.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 */
interface HttpClientInterface
{
	/**
	 * Sends a GET request.
	 *
	 * @param string $path       Request path
	 * @param array  $parameters GET parameters
	 * @param array  $headers    Configure request headers for this call only
	 *
	 * @return array Data
	 */
	public function get($path, array $parameters = array(), array $headers = array());

	/**
	 * Sends a POST request.
	 *
	 * @param string $path    Request path
	 * @param mixed  $body    Request body
	 * @param array  $headers Configure request headers for this call only
	 *
	 * @return array Data
	 */
	public function post($path, $body = null, array $headers = array());

	/**
	 * Sends a request to the server, receive a response,
	 * decode the response and returns an associative array.
	 *
	 * @param string $path       Request path
	 * @param mixed  $body       Request body
	 * @param string $httpMethod HTTP method to use
	 * @param array  $headers    Request headers
	 *
	 * @return array Data
	 */
	public function request($path, $body, $httpMethod = 'GET', array $headers = array());

	/**
	 * Change an option value.
	 *
	 * @param string $name  The option name
	 * @param mixed  $value The value
	 *
	 * @throws InvalidArgumentException
	 */
	public function setOption($name, $value);

	/**
	 * Set HTTP headers.
	 *
	 * @param array $headers
	 */
	public function setHeaders(array $headers);
}
