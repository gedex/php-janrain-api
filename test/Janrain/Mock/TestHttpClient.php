<?php

namespace Janrain\Tests\Mock;

use Janrain\HttpClient\HttpClientInterface;

class TestHttpClient implements HttpClientInterface
{

	public $requests = array(
		'get'  => array(),
		'post' => array(),
	);

	public $options = array();
	public $headers = array();

	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}

	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	public function get($path, array $parameters = array(), array $headers = array())
	{
		$this->requests['get'][] = $path;
	}

	public function post($path, $body = null, array $headers = array())
	{
		$this->requests['post'][] = $path;
	}

	public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
	{
		$this->requests[$httpMethod][] = $path;
	}
}
