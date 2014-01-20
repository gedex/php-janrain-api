<?php

namespace Janrain;

use Janrain\Api\ApiInterface;
use Janrain\Exception\InvalidArgumentException;
use Janrain\HttpClient\HttpClient;
use Janrain\HttpClient\HttpClientInterface;

/**
 * Janrain API client.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 */
class Client
{

	/**
	 * @var array
	 */
	private $options = array(
		'base_url'      => 'https://example.com',
		'user_agent'    => 'php-janrain-api (https://github.com/gedex/php-janrain-api)',
		'timeout'       => 15,
		'access_token'  => '',
		'client_id'     => '',
		'client_secret' => ''
	);

	/**
	 * HttpClient instance used to communicate with Janrain API
	 *
	 * @var HttpClient
	 */
	private $httpClient;

	public function __construct(HttpClientInterface $httpClient = null, array $options = array())
	{
		$this->httpClient = $httpClient;
		$this->options = array_merge($this->options, $options);
	}

	/**
	 *
	 * @param string $name
	 *
	 * @return ApiInterface
	 *
	 * @throws InvalidArgumentException
	 */
	public function api($name)
	{
		switch ($name) {
			case 'capture/clients':
			case 'clients':
				$api = new Api\Capture\Clients($this);
				break;
			case 'capture/entity':
			case 'entity':
				$api = new Api\Capture\Entity($this);
				break;
			case 'capture/oauth':
			case 'oauth':
				$api = new Api\Capture\OAuth($this);
				break;
			case 'capture/settings':
			case 'settings':
				$api = new Api\Capture\Settings($this);
				break;
			case 'capture/versions':
			case 'versions':
				$api = new Api\Capture\Versions($this);
				break;
			case 'capture/access':
			case 'access':
				$api = new Api\Capture\Access($this);
				break;
			case 'capture/webhooks':
			case 'webhooks':
				$api = new Api\Capture\Webhooks($this);
				break;
			case 'capture/entityType':
			case 'capture/entity_type':
			case 'entity_type':
			case 'entityType':
				$api = new Api\Capture\EntityType($this);
				break;
			case 'engage':
				$api = new Api\Engage\Engage($this);
				break;
			case 'engage/mapping':
			case 'mapping':
				$api = new Api\Engage\Mapping($this);
				break;
			case 'engage/sharing':
			case 'sharing':
				$api = new Api\Engage\Sharing($this);
				break;
			case 'engage/configure_rp':
			case 'engage/configureRp':
			case 'engage/configureRP':
			case 'configure_rp':
			case 'configureRp':
			case 'configureRP':
				$api = new Api\Engage\ConfigureRP($this);
				break;
			case 'engage/legacySharing':
			case 'engage/legacy_sharing':
			case 'legacySharing':
			case 'legacy_sharing':
				$api = new Api\Engage\LegacySharing($this);
				break;
			case 'partner':
				$api = new Api\Partner\Partner($this);
				break;
			case 'partner/admin':
			case 'admin':
				$api = new Api\Partner\Admin($this);
				break;
			case 'partner/app':
			case 'app':
				$api = new Api\Partner\App($this);
				break;
			default:
				throw new InvalidArgumentException(sprintf('Undefined Api instance called: "%s"', $name));
		}

		return $api;
	}

	public function getHttpClient()
	{
		if (null === $this->httpClient) {
			$this->httpClient = new HttpClient($this->options);
		}

		return $this->httpClient;
	}

	/**
	 * @param HttpClientInterface $httpClient
	 */
	public function setHttpClient(HttpClientInterface $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Clears used headers
	 */
	public function clearHeaders()
	{
		$this->getHttpClient()->clearHeaders();
	}

	/**
	 * @param array $headers
	 */
	public function setHeaders(array $headers)
	{
		$this->getHttpClient()->setHeaders($headers);
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 *
	 * @throws InvalidArgumentException
	 */
	public function getOption($name)
	{
		if (!array_key_exists($name, $this->options)) {
			throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
		}

		return $this->options[$name];
	}

	public function setOption($name, $value)
	{
		if (!array_key_exists($name, $this->options)) {
			throw new InvalidArgumentException(spritnf('Undefined option called: "%s"', $name));
		}

		$this->options[$name] = $value;
	}
}
