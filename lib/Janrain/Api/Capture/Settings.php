<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Settings extends AbstractApi
{
	/**
	 * Get the value associated with a key for a particular `client_id`. If the key
	 * has not value for that client, then return the key's default value for the
	 * application, or if they key has not default value, then return null.
	 *
	 * @param string $key The key whose value you want to retrieve. To find out the
	 *                    values available, use the 'settings/keys' API call first
	 *
	 * @param string $forClientId The client identifier. If you do not enter a value
	 *                            for this parameter, it defaults to the value of
	 *                            the `client_id`, that is, you are getting the
	 *                            value for a key in your own record.
	 */
	public function getSingle($key, $forClientId = null)
	{
		$params = array('key' => $key);

		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/get', $params);
	}

	/**
	 * Look up multiple keys. Each value is retrieved, as in the 'settings/get'
	 * command, by first looking at the client-specific setting, and then falling
	 * back to the application default setting.
	 *
	 * @param array $keys Array of the keys to retrieve
	 *
	 * @param string $forClientId The client identifier whose keys will be retrieved.
	 *                            If you do not enter a value for this parameter,
	 *                            it defaults to the value of the `client_id`,
	 *                            that is, you are getting the values for multiple
	 *                            keys in your own record
	 */
	public function getMulti(array $keys, $forClientId = null)
	{
		$params = json_encode(array_values($keys));

		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/get_multi', $params);
	}

	/**
	 * Get all settings for a particular client, including those from the application-
	 * wide default settings. If a key is defined in both the client and application
	 * settings, only the client-specific value is returned.
	 *
	 * @param string $forClientId The client identifier whose settings will be
	 *                            retrieved. If you do not enter a value for this
	 *                            parameter, it defaults to the value of the
	 *                            `client_id`
	 */
	public function items($forClientId = null)
	{
		$params = array();
		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/items', $params);
	}

	/**
	 * Get all keys for a particular client, including those from the application-
	 * wide default settings. Returns an array of the keys.
	 *
	 * @param string $forClientId The client identifier whose setting will be
	 *                            modified. If you do not enter a value for this
	 *                            parameter, it defaults to the value of the
	 *                            `client_id`, that is, you are modifying the
	 *                            settings for your own record
	 */
	public function keys($forClientId = null)
	{
		$params = array();
		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/keys', $params);
	}

	/**
	 * Assign a key-value pair for a particular `client_id`. If the key does not
	 * exist, it will be created. If they key already exists, this call overwrites
	 * the existing value.
	 *
	 * Returns a boolean that indicates whether the key already existed. True
	 * indicates the key has been overwritten. False indicates that a new key has
	 * been created.
	 *
	 * Note that you cannot use 'settings/set' to modify the application-wide
	 * default settings.
	 *
	 * @param string $key   The key to add or modify
	 * @param mixed  $value The value to assign to the key
	 *
	 * @param string $forClientId The client identifier whose setting will be
	 *                            modified. If you do not enter a value for this
	 *                            parameter, it defaults to the value of the
	 *                            `client_id`, that is, you are modifying the
	 *                            settings for your own record
	 */
	public function set($key, $value, $forClientId = null)
	{
		$params = array('key' => $key, 'value' => $value);
		if (is_array($value)) {
			$params['value'] = json_encode($value);
		}

		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/set', $params);
	}

	/**
	 * Assign multiple settings for a particular `client_id`. Returns a JSON
	 * object in which each key is mapped to a boolean that indicates whether the
	 * key already existed. True indicates that a previous key did exist and has
	 * been overwritten. False indicates that there were no previous key and a new
	 * key has been created. Does not modify application-wide settings.
	 *
	 * @param array $items Array containing key-value pairs to set for the client
	 *                     identifier.
	 *
	 * @param string $forClientId The client identifier whose settings will be
	 *                            modified. If you do not enter a value for this
	 *                            parameter, it defaults to the value of the
	 *                            `client_id`, that is, you are setting the values
	 *                            for multiple keys in your own record.
	 */
	public function setMulti(array $items, $forClientId = null)
	{
		$params = array('items' => json_encode($items));

		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/set_multi', $params);
	}

	/**
	 * Get the default value of a key for the current application. Returns the
	 * value of the key, or null if no such key exists.
	 *
	 * @param string $key The key whose value you want to retrieve. To find out
	 *                    the values available, use the 'settings/keys' API call
	 *                    first.
	 */
	public function getDefault($key)
	{
		return $this->post('settings/get_default', array('key' => $key));
	}

	/**
	 * Set the application-wide default value for a key. This will create a new
	 * key with a default value, if the key does not yet exist in the application.
	 * If the key does exist, the value will be overwritten.
	 *
	 * Returns a boolean that indicates whether the key already existed. "True"
	 * indicates the key has been overwritten. "False" indicates that a new key
	 * has been created.
	 *
	 * @param string $key   The key to add or modifiy
	 * @param string $value The value to assign to the key
	 */
	public function setDefault($key, $value)
	{
		$params = array('key' => $key, 'value' => $value);
		if (is_array($value)) {
			$params['value'] = json_encode($value);
		}

		return $this->post('settings/set_default', $params);
	}

	/**
	 * Delete a key from the settings for a particular client. Returns a boolean
	 * indicating whether the key existed. This does not modify the application-
	 * wide default value for a key.
	 *
	 * @param string $key The key to delete from the client settings. To find out
	 *                    the values available, use the 'settings/keys' API call
	 *                    first.
	 *
	 * @param string $forClientId The client identifier whose key will be deleted
	 *                            If you do not enter a value for this parameter,
	 *                            it defaults to the value of the `client_id`. In
	 *                            this case, you will delete the key from your
	 *                            own account.
	 */
	public function delete($key, $forClientId = null)
	{
		$params = array('key' => $key);

		if ($forClientId) {
			$params['for_client_id'] = $forClientId;
		}

		return $this->post('settings/delete', $params);
	}

	/**
	 * Delete a key from the application-wide default settings. Returns a
	 * boolean indicating whether the key existed. This does not modify any
	 * per-client settings.
	 *
	 * @param string $key The key to delete from the application settings.
	 *                    To find out the values available, use 'settings/keys'
	 *                    API call first.
	 */
	public function deleteDefault($key)
	{
		return $this->post('settings/delete_default', array('key' => $key));
	}
}
