<?php

namespace Janrain\Api\Engage;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class LegacySharing extends AbstractApi
{
	/**
	 * Allows a user to post an activity update to the user's activity stream. The
	 * identity providers that support activity posting are: Facebook, LinkedIn,
	 * Twitter, and Yahoo!.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/legacy/activity/
	 */
	public function activity(array $params)
	{
		if (!isset($params['activity'])) {
			throw new MissingArgumentException('activity');
		}

		return $this->post('activity', $params);
	}

	/**
	 * Authenticate the share widget only.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/legacy/auth_infos/
	 */
	public function authInfos(array $params)
	{
		if (!isset($params['tokens'])) {
			throw new MissingArgumentException('tokens');
		}

		return $this->post('auth_infos', $params);
	}

	/**
	 * Updates the user status using the current signed in identity provider.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/legacy/set_status/
	 */
	public function setStatus(array $params)
	{
		if (!isset($params['identifier'])) {
			throw new MissingArgumentException('identifier');
		}

		if (!isset($params['status'])) {
			throw new MissingArgumentException('status');
		}

		return $this->post('set_status', $params);
	}
}
