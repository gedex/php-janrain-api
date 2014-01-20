<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Clients extends AbstractApi
{
	public function add(array $params)
	{
		if (!isset($params['description'])) {
			throw new MissingArgumentException('description');
		}

		return $this->post('clients/add', $params);
	}

	public function clearWhitelist($clientId = null)
	{
		$params = array();
		if ($clientId) {
			$params['for_client_id'] = $clientId;
		}

		return $this->post('clients/clear_whitelist', $params);
	}

	public function delete($clientId)
	{
		$params = array('client_id_for_deletion' => $clientId);

		return $this->post('clients/delete', $params);
	}

	/**
	 * Since `list` is reserved keyword in PHP.
	 */
	public function getList()
	{
		return $this->post('clients/list');
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
	 * @param string $clientId
	 * @param string $description
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
