<?php

namespace Janrain\Api\Engage;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;
use Janrain\Exception\InvalidArgumentException;

class Sharing extends AbstractApi
{
	/**
	 * Shares activity information directly with a provider. The information
	 * provided in the parameters is passed to a provider to publish on their
	 * network.
	 *
	 * The `broadcast` call shares with one provider at a time, determined by the
	 * `identifier` or `device_token` that you use.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/sharing-widget/broadcast/
	 */
	public function broadcast(array $params)
	{
		if (!isset($params['identifier']) && !isset($params['device_token'])) {
			throw new MissingArgumentException('identifier or device_token');
		}

		if (!isset($params['message'])) {
			throw new MissingArgumentException('message');
		}

		return $this->post('sharing/broadcast', $params);
	}

	/**
	 * Shares activity information directly with the specified recipents on a
	 * provider's network, instead of publishing it to everyone on the network.
	 *
	 * The `direct` call shares with one provider at a time, determined by the
	 * `identifier` or `device_token` you enter.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/sharing-widget/direct/
	 */
	public function direct(array $params)
	{
		if (!isset($params['identifier']) && !isset($params['device_token'])) {
			throw new MissingArgumentException('identifier or device_token');
		}

		if (!isset($params['recipients'])) {
			throw new MissingArgumentException('recipients');
		} else if (!is_array($params['recipients'])) {
			throw new InvalidArgumentException('Invalid Argument: recipients must be passed as array');
		} else {
			$params['recipients'] = json_encode(array_values($params['recipients']));
		}

		if (!isset($params['message'])) {
			throw new MissingArgumentException('message');
		}

		return $this->post('sharing/direct', $params);
	}

	/**
	 * Returns the number of a times a given URL has been shared.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/sharing-widget/get_share_count-2/
	 */
	public function getShareCount($url, array $params = array())
	{
		$params['url'] = $url;

		return $this->post('get_share_count', $params);
	}

	/**
	 * Returns a list of email and sharing providers configured for the widget.
	 * This call has no required parameters; it identifies the proper application
	 * by the realm prefacing the URL path.
	 *
	 * @param string $format   Either 'json' or 'xml'
	 * @param string $callback Specifies the return of a JSONP-formatted response
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/sharing-widget/get_share_providers/
	 */
	public function getShareProviders($format = 'json', $callback = '')
	{
		$params = compact('format');
		if (!empty($callback)) {
			$params['callback'] = $callback;
		}

		return $this->post('get_share_providers', $params);
	}

	/**
	 * Defines the providers offered by the new Social Sharing Widget. You can set
	 * both sharing and email providers.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/sharing-widget/set_share_providers/
	 */
	public function setShareProviders(array $params)
	{
		if (!isset($params['share'])) {
			throw new MissingArgumentException('share');
		}

		return $this->post('set_share_providers', $params);
	}
}
