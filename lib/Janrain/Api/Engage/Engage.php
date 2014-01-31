<?php

namespace Janrain\Api\Engage;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;
use Janrain\Exception\InvalidArgumentException;

class Engage extends AbstractApi
{
	/**
	 * Adds or updates an OAuth 'access_token' for a user outside the usual Engage
	 * sign-in flow.
	 */
	public function addOrUpdateAccessToken($identifier, $format = 'json')
	{
		return $this->post('add_or_update_access_token', compact('identifier', 'format'));
	}

	/**
	 * Retrieve profile information of the user.
	 *
	 * @param array $params
	 */
	public function authInfo(array $params = array())
	{
		return $this->post('auth_info', $params);
	}

	/**
	 * Gets application properties (from the application settings page of the
	 * dashboard),
	 *
	 * @param string $format The format in which you want the response: either
	 *                       'xml' or 'json'. Default to 'json'
	 */
	public function getAppSettings($format = 'json')
	{
		return $this->post('get_app_settings', compact('format'));
	}

	/**
	 * Returns a list of configured providers for an application. The providers
	 * call is similar, but only returns providers configured for a widget. If you
	 * are using custom code for Engage instead of using a widget, this call is
	 * used instead.
	 *
	 * @param array $params
	 */
	public function getAvailableProviders(array $params = array())
	{
		return $this->post('get_available_providers', $params);
	}

	/**
	 * Returns a list of all the contacts related to the user.
	 *
	 * @param array $params
	 */
	public function getContacts(array $params = array())
	{
		if (!isset($params['identifier'])) {
			throw new MissingArgumentException('identifier');
		}

		return $this->post('get_contacts', $params);
	}

	/**
	 * Returns an up-to-date copy of a user's profile as previously returned by an
	 * 'auth_info' API call.
	 *
	 * @param array $params
	 */
	public function getUserData(array $params = array())
	{
		if (!isset($params['identifier'])) {
			throw new MissingArgumentException('identifier');
		}

		return $this->post('get_user_data', $params);
	}

	/**
	 * Returns a list of configured sign-in or social providers configured for a
	 * widget.
	 *
	 * @param string $format Either 'xml' or 'json'
	 */
	public function providers($format = 'json')
	{
		return $this->post('providers', compact('format'));
	}

	/**
	 * Set application properties (from the application settings page of the
	 * dashboard).
	 *
	 * @param array $params
	 */
	public function setAppSettings(array $params = array())
	{
		return $this->post('set_app_settings', $params);
	}

	/**
	 * Defines the list of identity providers provided by the Engage server to
	 * sign-in widgets. This is the same list that is managed by the dashboard.
	 *
	 * @param array $params
	 */
	public function setAuthProviders(array $params = array())
	{
		if (!isset($params['providers'])) {
			throw new MissingArgumentException('providers');
		}

		if (!is_array($params['providers'])) {
			throw new InvalidArgumentException('Invalid Argument: providers must be passed as array');
		}

		$params['providers'] = json_encode(array_values($params['providers']));

		return $this->post('set_auth_providers', $params);
	}
}
