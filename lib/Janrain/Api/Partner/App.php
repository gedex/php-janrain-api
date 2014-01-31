<?php

namespace Janrain\Api\Partner;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class App extends AbstractApi
{
	/**
	 * Creates a bus owner and password, and a new Backplane bus with the new
	 * owner of the new bus.
	 */
	public function addBpBus()
	{
		return $this->post('app/add_bp_bus');
	}

	/**
	 * Returns a lists of all applications managed by a partner.
	 *
	 * @param string $format Either 'json' or 'xml'
	 */
	public function apps($format = 'json')
	{
		return $this->post('apps', compact('partner'));
	}

	/**
	 * Adds a domain to an existing Engage application.
	 *
	 * @param string $domain The domain to add
	 * @param string $format Either 'json' or 'xml'
	 */
	public function addDomain($domain, $format = 'json')
	{
		return $this->post('app/add_domain', compact('domain', 'format'));
	}

	/**
	 * Creates a new Engage application.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/app/create/
	 */
	public function create(array $params)
	{
		if (!isset($params['email'])) {
			throw new MissingArgumentException('email');
		}

		if (!isset($params['name'])) {
			throw new MissingArgumentException('name');
		}

		if (!isset($params['domain'])) {
			throw new MissingArgumentException('domain');
		}

		return $this->post('app/create', $params);
	}

	/**
	 * Generates an email invitation for administrative access to an existing
	 * application.
	 *
	 * @param string $email  The adminstrative email address to be associated with
	 *                       the Engage application
	 * @param string $format Either 'json' or 'xml'
	 */
	public function createInvite($email, $format = 'json')
	{
		return $this->post('app/create_invite', compact('email', 'format'));
	}

	/**
	 * Deletes an existing Engage application.
	 *
	 * @param string $format Either 'json' or 'xml'
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/app/delete/
	 */
	public function delete($format = 'json')
	{
		return $this->post('app/delete', compact('format'));
	}

	/**
	 * Gets a list of all pending invitations for an Engage application.
	 *
	 * @deprecated
	 * @deprecated Please use the `admin/get` call instead
	 *
	 * @param string $format Either 'json' or 'xml'
	 */
	public function getPendingInvites($format = 'json')
	{
		return $this->post('app/get_pending_invites', compact('format'));
	}

	/**
	 * Returns an Engage application's permissions for a provider, as set with the
	 * `set_provider_permissions` call.
	 *
	 * @param string $provider The name of the provider about which you want
	 *                         information
	 * @param string $format   Either 'json' or 'xml'
	 */
	public function getProviderPermissions($provider, $format = 'json')
	{
		return $this->post('app/get_provider_permissions', compact('provider', 'format'));
	}

	/**
	 * Sets an Engage application's permissions for a provider. The permissions
	 * that you can set depend on the provider, service level, and whether the
	 * provider has been configured or not. You can set permissions, if, and only
	 * if, you pass them in the permissions parameter. Each requests replaces the
	 * existing set of permissions. The old ones are cleared and the new ones set.
	 *
	 * @param string $provider The name of the provder. This call supports only
	 *                         `facebook`, `google`, `mixi`, `linkedin`, and
	 *                         `paypal`.
	 *
	 * @param string $permissions A comman-separated list of permissions to set.
	 *                            Each provider has its own specific permissions
	 *
	 * @param string $format Either 'json' or 'xml'
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/app/set_provider_permissions/
	 */
	public function setProviderPermissions($provider, $permissions, $format = 'json')
	{
		return $this->post('app/set_provider_permissions', compact('provider', 'permissions', 'format'));
	}

	/**
	 * Resets the API key for a given partner RP application.
	 *
	 * @param string $appId  The application identifier of the RP application for
	 *                       which you want to reset the API key
	 * @param string $format Either 'json' or 'xml'
	 */
	public function resetApiKey($appId, $format = 'json')
	{
		return $this->post('app/reset_api_key', compact('appId', 'format'));
	}

	/**
	 * Configures Engage application properties for a given application.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/app/set_properties/
	 */
	public function setProperties(array $params)
	{
		if (!isset($params['provider'])) {
			throw new MissingArgumentException('provider');
		}

		return $this->post('app/set_properties', $params);
	}

	/**
	 * Returns a list of the configured properties for an Engage application.
	 *
	 * @param string $provider The name of the provider whose properties you want
	 *                         to return.
	 * @param string $format   Either 'json' or 'xml'
	 */
	public function getProperties($provider, $format = 'json')
	{
		return $this->post('app/get_properties', compact('provider', 'format'));
	}

	/**
	 * Automates the server-side component of the provider-specific domain
	 * verification mechanism.
	 *
	 * @param array $params
	 */
	public function verifyDomain(array $params)
	{
		if (!isset($params['provider'])) {
			throw new MissingArgumentException('provider');
		}

		if (!isset($params['code'])) {
			throw new MissingArgumentException('code');
		}

		if (!isset($params['filename'])) {
			throw new MissingArgumentException('filename');
		}

		return $this->post('app/verify_domain', $params);
	}
}
