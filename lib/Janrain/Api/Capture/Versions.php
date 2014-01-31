<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Versions extends AbstractApi
{
	/**
	 * Retrieve a past value of single entity by primary key and timestamp.
	 *
	 * @param string $entityType
	 * @param string $id
	 * @param string $timestamp
	 */
	public function entity($entityType, $id, $timestamp)
	{
		$params = array(
			'type_name' => $entityType,
			'id'        => $id,
			'timestamp' => $timestamp,
		);

		return $this->post('versions/entity', $params);
	}

	/**
	 * Retrieve a past schema of an entityType by timestamp.
	 *
	 * @param string $entityType
	 * @param string $timestamp
	 */
	public function entityType($entityType, $timestamp)
	{
		$params = array('type_name' => $entityType, 'timestamp' => $timestamp);

		return $this->post('versions/entityType', $params);
	}
}
