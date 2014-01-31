<?php

namespace Janrain\Api\Engage;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Mapping extends AbstractApi
{
	/**
	 * Returns all of the stored mappings of an application. These mappings
	 * associate users with multiple identity provider accounts using a primary
	 * key.
	 *
	 * @param string $format Either 'json' or 'xml'
	 */
	public function allMappings($format = 'json')
	{
		return $this->post('all_mappings', compact('format'));
	}

	/**
	 * Associates a primary key with a user's social identity.
	 *
	 * @param array $params
	 */
	public function map(array $params)
	{
		if (!isset($params['ientifier'])) {
			throw new MissingArgumentException('identifier');
		}

		if (!isset($params['primaryKey'])) {
			throw new MissingArgumentException('primaryKey');
		}

		if (!isset($params['format'])) {
			$params['format'] = 'json';
		}

		return $this->post('map', $params);
	}

	/**
	 * Returns all the stored identity providers associated with a particular user's
	 * primary key.
	 *
	 * @param string $primaryKey The primary key from your users table, as a string
	 * @param string $format     Either 'json' or 'xml'
	 */
	public function mappings($primaryKey, $format = 'json')
	{
		return $this->post('mappings', array('primaryKey' => $primaryKey, 'format' => $format));
	}

	/**
	 * Removes an identity provider from a primary key as well as allowing you to
	 * optionally unlink your application from the user's account with the provider.
	 *
	 * @param array $params
	 */
	public function unmap(array $params)
	{
		if (!isset($params['ientifier'])) {
			throw new MissingArgumentException('identifier');
		}

		if (!isset($params['all_identifiers'])) {
			throw new MissingArgumentException('all_identifiers');
		}

		if (!isset($params['primaryKey'])) {
			throw new MissingArgumentException('primaryKey');
		}

		if (!isset($params['unlink'])) {
			throw new MissingArgumentException('unlink');
		}

		if (!isset($params['format'])) {
			$params['format'] = 'json';
		}

		return $this->post('unmap', $params);
	}
}
