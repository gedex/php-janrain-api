<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class EntityType extends AbstractApi
{
	/**
	 * @param string $entityType
	 */
	public function show($entityType)
	{
		return $this->post('entityType', array('type_name' => $entityType));
	}

	/**
	 * @param string $entityType
	 * @param array  $attributes
	 */
	public function addAttribute($entityType, array $attributes)
	{
		$params = array('type_name' => $entityType, 'attr_def' => json_encode($attributes));

		return $this->post('entityType.addAttribute', $params);
	}

	/**
	 * @param string $entityType
	 * @param array  $params
	 */
	public function addRule($entityType, array $params)
	{
		$params['type_name'] = $entityType;

		if (!isset($params['attributes'])) {
			throw new MissingArgumentException('attributes');
		}
		$params['attributes'] = json_encode(array_values($params['attributes']));

		if (!isset($params['description'])) {
			throw new MissingArgumentException('description');
		}

		if (!isset($params['definition'])) {
			throw new MissingArgumentException('definition');
		}
		$params['definition'] = json_encode($params['definition']);

		return $this->post('entityType.addRule', $params);
	}

	/**
	 * @param string $name     A new (unique) name for the entityType
	 * @param array  $attrDefs An initial set attributes to add
	 */
	public function create($name, array $attrDefs)
	{
		$params = array('type_name' => $name, 'attr_defs' => json_encode($attrDefs));

		return $this->post('entityType.create', $params);
	}

	/**
	 * @param string $entityType
	 * @param string $forClientId
	 * @param string $accessType
	 */
	public function getAccessSchema($entityType, $forClientId, $accessType = 'read')
	{
		return $this->post('entityType.getAccessSchema', array('type_name' => $entityType, 'for_client_id' => $forClientId, 'access_type' => $accessType));
	}

	public function getList()
	{
		return $this->post('entityType.list');
	}

	/**
	 * @param string $entityType
	 * @param string $attributeName
	 */
	public function removeAttribute($entityType, $attributeName)
	{
		return $this->post('entityType.removeAttribute', array('type_name' => $entityType, 'attribute_name' => $attributeName));
	}

	/**
	 * @param string $uuid
	 */
	public function removeRule($uuid)
	{
		return $this->post('entityType.removeRule', compact('uuid'));
	}

	/**
	 * @param string $entityType
	 */
	public function rules($entityType)
	{
		return $this->post('entityType.rules', array('type_name' => $entityType));
	}

	/**
	 * @param string $entityType
	 * @param string $forClientId
	 * @param string $accessType
	 * @param array  $attributes
	 */
	public function setAccessSchema($entityType, $forClientId, $accessType, array $attributes = array())
	{
		$params = array(
			'type_name'     => $entityType,
			'for_client_id' => $forClientId,
			'access_type'   => $accessType,
			'attributes'    => json_encode(array_values($attributes)),
		);

		return $this->post('entityType.setAccessSchema', $params);
	}

	/**
	 * @param string $entityType
	 * @param string $attributeName
	 * @param array  $constraints
	 */
	public function setAttributeConstraints($entityType, $attributeName, array $constraints = array())
	{
		$params = array(
			'type_name'      => $entityType,
			'attribute_name' => $forClientId,
			'constraints'    => json_encode(array_values($attributes)),
		);

		return $this->post('entityType.setAttributeConstraints', $params);
	}
}
