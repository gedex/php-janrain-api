<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Clients extends AbstractApi
{
	/**
	 * Add a new client to Capture. Once created, your new client will have access
	 * to the Capture API, and if applicable, the Capture UI. Default clients have
	 * no permissions, so you need to configure them in the dashboard, unless you
	 * add permissions using the `features` parameter.
	 *
	 * @param array $params Array containing 'description' and 'features'.
	 *                      Description contains string description of the client.
	 *                      Features contain array of features names that the
	 *                      client has; defaults to the empty list. Permissions to
	 *                      add include: 'access_issuer', 'direct_access',
	 *                      'direct_read_access', and 'image_create'
	 */
	public function add(array $params)
	{
		if (!isset($params['description'])) {
			throw new MissingArgumentException('description');
		}

		return $this->post('clients/add', $params);
	}

	/**
	 * Clear the IP whitelist for a target client, resetting it to the default
	 * value that allows all IP addresses. Only the 'owner' client may make this
	 * API call. The default whitelist is `["0.0.0.0/0"]`, which means that all IP
	 * addresses are allowed.
	 *
	 * @param string $clientId The `client_id` whose whitelist will be cleared. If
	 *                         you don't use this parameter, the whitelist will be
	 *                         cleared for the 'owner' client
	 */
	public function clearWhitelist($clientId = null)
	{
		$params = array();
		if ($clientId) {
			$params['for_client_id'] = $clientId;
		}

		return $this->post('clients/clear_whitelist', $params);
	}

	/**
	 * Delete a client from Capture. Only the 'owner' client may make this API
	 * call.
	 *
	 * @param string $clientId The 'client_id' to delete
	 */
	public function delete($clientId)
	{
		$params = array('client_id_for_deletion' => $clientId);

		return $this->post('clients/delete', $params);
	}

	/**
	 * Since `list` is reserved keyword in PHP.
	 *
	 * Get a list of the clients in your Capture application, optionally filtered
	 * by client feature. Only the 'owner' client can make this API call.
	 *
	 * @param array $hasFeatures Array features names; only clients which have at
	 *                           least one of the features in the array will be
	 *                           displayed
	 */
	public function getList(array $hasFeatures = array())
	{
		$params = array();
		if (!empty($hasFeatures)) {
			$params['features'] = json_encode(array_values($hasFeatures));
		}

		return $this->post('clients/list', $params);
	}

	/**
	 * Alias for getList/list.
	 */
	public function all()
	{
		return $this->getList();
	}

	/**
	 * Generates a new client secret for a specified client id.
	 *
	 * @param string $clientId    Client ID whose secret will be reset
	 * @param int    $hoursToLive An integer between 0 and 168, defining
	 *                            how many hours the old client will be
	 *                            valid.
	 */
	public function resetSecret($clientId, $hoursToLive)
	{
		$params = array(
			'for_client_id' => $clientId,
			'hours_to_live' => $hoursToLive,
		);

		return $this->post('clients/reset_secret', $params);
	}

	/**
	 * Change the description of a client. This can also be thought of as the
	 * 'name' of the client. This API call may only be made by the owner client.
	 *
	 * @param string $clientId    The client id of the client having it's
	 *                            description changed
	 * @param string $description The new description for the target client
	 */
	public function setDescription($clientId, $description)
	{
		$params = array(
			'for_client_id' => $clientId,
			'description'   => $description,
		);

		// If empty, description is set for the owner client.
		if (!$params['for_client_id']) {
			unset($params['for_client_id']);
		}

		return $this->post('clients/set_description', $params);
	}

	/**
	 * Change the features that a target client has by overwriting the old feature
	 * list. This API call may only be made by the 'owner' client. The owner client
	 * may not remove the 'owner' feature from itself.
	 *
	 * @param string $clientId The client id for which to set features
	 * @param array  $features Array of feature names to assign to the client
	 */
	public function setFeatures($clientId, array $features)
	{
		$params = array(
			'for_client_id' => $clientId,
			'features'      => json_encode($features),
		);

		// If empty, features are set for the owner client.
		if (!$params['for_client_id']) {
			unset($params['for_client_id']);
		}

		return $this->post('clients/set_features', $params);
	}

	/**
	 * Change the IP whitelist for a target client, overwriting the previous whitelist.
	 *
	 * @param string $clientId  Client ID
	 * @param array  $addresses Array of CIDR addresses
	 */
	public function setWhiteList($clientId, array $addresses)
	{
		$params = array(
			'for_client_id' => $clientId,
			'whitelist'     => json_encode($addresses),
		);

		// If empty, features are set for the owner client.
		if (!$params['for_client_id']) {
			unset($params['for_client_id']);
		}

		return $this->post('clients/set_whitelist', $params);
	}
}
