<?php

namespace Janrain\HttpClient\Listener;

use Guzzle\Common\Event;
use Janrain\Client;
use Janrain\Exception\MissingArgumentException;
use Janrain\Exception\RuntimeException;

class AuthListener
{
	private $options;

	public function __construct(array $options = array())
	{
		$this->options = $options;
	}

	public function onRequestBeforeSend(Event $event)
	{
		$url = $event['request']->getUrl();

		$parameters = array();

		// Use either 'access_token' or 'client_id' paired with 'client_secret'.
		// Prioritize 'access_token' over 'client_id' and 'client_secret'.
		if (isset($this->options['access_token']) && $this->options['access_token']) {
			$parameters['access_token'] = $this->options['access_token'];

			// Some endpoints expect 'token' instead of 'access_token'.
			$parameters['token'] = $this->options['access_token'];
		} else if (isset($this->options['client_id']) && $this->options['client_id'] && isset($this->options['client_secret']) && $this->options['client_secret']) {
			$parameters['client_id']     = $this->options['client_id'];
			$parameters['client_secret'] = $this->options['client_secret'];
		} else {
			throw new MissingArgumentException(array('access_token', 'client_id', 'client_secret'));
		}

		// Most Engage API calls need 'apiKey'.
		if (isset($this->options['api_key']) && $this->options['api_key']) {
			$parameters['apiKey'] = $this->options['api_key'];
		}

		// Most Partner API calls need 'partnerKey'.
		if (isset($this->options['partner_key']) && $this->options['partner_key']) {
			$parameters['partnerKey'] = $this->options['partner_key'];
		}

		$url .= (false === strpos($url, '?') ? '?' : '&');
		$url .= utf8_encode(http_build_query($parameters, '', '&'));

		$event['request']->setUrl($url);
	}
}
