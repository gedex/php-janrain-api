<?php

namespace Janrain\HttpClient;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;

use Janrain\Exception\ErrorException;
use Janrain\Exception\RuntimeException;
use Janrain\HttpClient\Listener\AuthListener;
use Janrain\HttpClient\Listener\ErrorListener;

/**
 * Performs requests on Janrain API.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 */
class HttpClient implements HttpClientInterface
{
	protected $options = array(
		'base_url'      => 'https://example.com',
		'user_agent'    => 'php-janrain-api (https://github.com/gedex/php-janrain-api)',
		'timeout'       => 15,
		'access_token'  => '',
		'api_key'       => '',
		'client_id'     => '',
		'client_secret' => '',
		'partner_key'   => '',
	);

	protected $headers = array();

	private $lastResponse;
	private $lastRequest;

	/**
	 * @param array           $options
	 * @param ClientInterface $client
	 */
	public function __construct(array $options = array(), ClientInterface $client = null)
	{
		$this->options = array_merge($this->options, $options);
		$client = $client ?: new GuzzleClient($this->options['base_url'], $this->options);
		$this->client = $client;

		$this->addListener('request.before_send', array(
			new AuthListener($this->options), 'onRequestBeforeSend'
		));

		$errorListener = new ErrorListener($this->options);
		$this->addListener('request.error', array($errorListener, 'onRequestError'));

		// Janrain returns status code 200 even if error occurred.
		$this->addListener('request.success', array($errorListener, 'onRequestError'));

		$this->clearHeaders();
	}

	/**
	 * {@inheritDoc}
	 */
	public function setOption($name, $value)
	{
		$this->options[$name] = $value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = array_merge($this->headers, $headers);
	}

	/**
	 * Clears used headers.
	 */
	public function clearHeaders()
	{
		$this->headers = array(
			'User-Agent' => sprintf('%s', $this->options['user_agent']),
		);
	}

	public function addListener($eventName, $listener)
	{
		$this->client->getEventDispatcher()->addListener($eventName, $listener);
	}

	/**
	 * {@inheritDoc}
	 */
	public function get($path, array $parameters = array(), array $headers = array())
	{
		return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
	}

	/**
	 * {@inheritDoc}
	 */
	public function post($path, $body = null, array $headers = array())
	{
		return $this->request($path, $body, 'POST', $headers);
	}

	/**
	 * {@inheritDoc}
	 */
	public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
	{
		$request = $this->createRequest($httpMethod, $path, $body, $headers, $options);
		$request->addHeaders($headers);

		try {
			$response = $this->client->send($request);
		} catch (\LogicException $e) {
			throw new ErrorException($e->getMessage());
		} catch (\RuntimeException $e) {
			throw new RuntimeException($e->getMessage());
		}

		return $response;
	}

	protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
	{
		return $this->client->createRequest(
			$httpMethod,
			$path,
			array_merge($this->headers, $headers),
			$body,
			$options
		);
	}
}
