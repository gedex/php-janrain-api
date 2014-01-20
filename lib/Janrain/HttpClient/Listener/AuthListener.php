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
		if ($this->options['access_token']) {
			$parameters['access_token'] = $this->options['access_token'];
		} else if ($this->options['client_id'] && $this->options['client_secret']) {
			$parameters['client_id']     = $this->options['client_id'];
			$parameters['client_secret'] = $this->options['client_secret'];
		} else {
			throw new MissingArgumentException(array('access_token', 'client_id', 'client_secret'));
		}

		$url .= (false === strpos($url, '?') ? '?' : '&');
		$url .= utf8_encode(http_build_query($parameters, '', '&'));

		$event['request']->setUrl($url);
	}
}
