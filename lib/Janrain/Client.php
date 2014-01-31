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
		'api_key'       => '',
		'client_id'     => '',
		'client_secret' => '',
		'partner_key'   => '',
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
		// Either 'capture', 'engage', or 'partner'.
		$section = '';

		switch ($name) {
			case 'capture/clients':
			case 'clients':
				$api = new Api\Capture\Clients($this);
				$section = 'capture';
				break;
			case 'capture/entity':
			case 'entity':
				$api = new Api\Capture\Entity($this);
				$section = 'capture';
				break;
			case 'capture/oauth':
			case 'oauth':
				$api = new Api\Capture\OAuth($this);
				$section = 'capture';
				break;
			case 'capture/settings':
			case 'settings':
				$api = new Api\Capture\Settings($this);
				$section = 'capture';
				break;
			case 'capture/versions':
			case 'versions':
				$api = new Api\Capture\Versions($this);
				$section = 'capture';
				break;
			case 'capture/access':
			case 'access':
				$api = new Api\Capture\Access($this);
				$section = 'capture';
				break;
			case 'capture/webhooks':
			case 'webhooks':
				$api = new Api\Capture\Webhooks($this);
				$section = 'capture';
				break;
			case 'capture/entityType':
			case 'capture/entity_type':
			case 'entity_type':
			case 'entityType':
				$api = new Api\Capture\EntityType($this);
				$section = 'capture';
				break;
			case 'engage':
				$api = new Api\Engage\Engage($this);
				$section = 'engage';
				break;
			case 'engage/mapping':
			case 'mapping':
				$api = new Api\Engage\Mapping($this);
				$section = 'engage';
				break;
			case 'engage/sharing':
			case 'sharing':
				$api = new Api\Engage\Sharing($this);
				$section = 'engage';
				break;
			case 'engage/configure_rp':
			case 'engage/configureRp':
			case 'engage/configureRP':
			case 'configure_rp':
			case 'configureRp':
			case 'configureRP':
				$api = new Api\Engage\ConfigureRP($this);
				$section = 'engage';
				break;
			case 'engage/legacySharing':
			case 'engage/legacy_sharing':
			case 'legacySharing':
			case 'legacy_sharing':
				$api = new Api\Engage\LegacySharing($this);
				$section = 'engage';
				break;
			case 'partner':
				$api = new Api\Partner\Partner($this);
				$section = 'partner';
				break;
			case 'partner/admin':
			case 'admin':
				$api = new Api\Partner\Admin($this);
				$section = 'partner';
				break;
			case 'partner/app':
			case 'app':
				$api = new Api\Partner\App($this);
				$section = 'partner';
				break;
			default:
				throw new InvalidArgumentException(sprintf('Undefined Api instance called: "%s"', $name));
		}

		// Engage and Partner endpoints have different domain than Capture. However,
		// Engage has common prefix path '/api/v2/' while Partner has fixed domain,
		// 'https://rxpnow.com', and prefix path, '/partner/v2'.
		if ('engage' === $section) {
			$url = $this->getOption('base_url');
			if (false === strpos($url, 'api/v2')) {
				$this->setOption('base_url', rtrim($url, '/') . '/api/v2');
			}
		} else if ('partner' === $section) {
			$this->setOption('base_url', 'https://rpxnow.com/partner/v2');
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
