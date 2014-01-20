<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\InvalidArgumentException;
use Janrain\Exception\MissingArgumentException;

class Entity extends AbstractApi
{
	/**
	 * Get entity by UUID.
	 */
	public function view($uuid, array $params)
	{
		$params['uuid'] = $uuid;

		return $this->_view($params);
	}

	public function viewById($id, array $params)
	{
		$params['id'] = $id;

		return $this->_view($params);
	}

	public function viewByAttribute($attributeKey, $attributeValue, array $params)
	{
		$params['key_attribute'] = $attributeKey;
		$params['key_value']     = "'{$attributeValue}'"; // String values need to be enclosed in quotes

		return $this->_view($params);
	}

	protected function _view($params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}
		if (isset($params['attributes']) && is_array($params['attributes'])) {
			$params['attributes'] = json_encode($params['attributes']);
		}
		return $this->post('entity', $params);
	}

	/**
	 * Count the number of records in an entityType.
	 *
	 * @param string $entityType The entityType of the entity
	 * @param string $filter     The expression to use to filter the results.
	 */
	public function count($entityType, $filter = '')
	{
		$params = array('type_name' => $entityType);
		if (!empty($filter)) {
			$params['filter'] = $filter;
		}
		return $this->post('entity.count', $params);
	}

	public function create()
	{

	}

	public function bulkCreate()
	{
		;
	}

	/**
	 * Default by UUID.
	 */
	public function delete($uuid, array $params)
	{
		$params['uuid'] = $uuid;

		return $this->_del($params);
	}

	public function deleteById($id, array $params)
	{
		$params['id'] = $id;

		return $this->_del($params);
	}

	public function deleteByAttribute($attributeKey, $attributeValue, array $params)
	{
		$params['key_attribute'] = $attributeKey;
		$params['key_value']     = "'{$attributeValue}'"; // String values need to be enclosed in quotes

		return $this->_del($params);
	}

	protected function _del($params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}
		return $this->post('entity.delete', $params);
	}

	public function bulkDelete()
	{

	}

	public function find(array $params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}

		if (isset($params['attributes'])) {
			if (is_array($params['attributes']) && !empty($params['attributes'])) {
				if (1 === sizeof($params['attributes']) && empty($params['attributes'][0])) {
					unset($params['attributes']);
				} else {
					$params['attributes'] = json_encode($params['attributes']);
				}
			} else if (empty($params['attributes'])) {
				unset($params['attributes']);
			}
		}

		if (isset($params['sort_on']) && !empty($params['sort_on'])) {
			if (is_array($params['sort_on'])) {
				$params['sort_on'] = json_encode($params['sort_on']);
			} else {
				throw new InvalidArgumentException('Invalid Argument: sort_on must be passed as array');
			}
		} else {
			unset($params['sort_on']);
		}

		return $this->post('entity.find', $params);
	}

	public function purge()
	{

	}

	/**
	 * Replace part of an entity by UUID.
	 */
	public function replace()
	{

	}

	public function _replace(array $params)
	{
		return $this->post('entity.udpate', $params);
	}

	/**
	 * Update entity by UUID.
	 */
	public function update($uuid, array $params)
	{
		$params['uuid'] = $uuid;

		return $this->_update($params);
	}

	/**
	 * Update entity by ID
	 */
	public function updateById($id, array $params)
	{
		$params['id'] = $id;

		return $this->_update($params);
	}

	/**
	 * Update entity by attribute
	 */
	public function updateByAttribute($attributeKey, $attributeValue, array $params)
	{
		$params['key_attribute'] = $attributeKey;
		$params['key_value']     = "'{$attributeValue}'"; // String values need to be enclosed in quotes

		return $this->_del($params);
	}

	public function _update(array $params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}

		if (isset($params['attribute_name'])) {
			if (!isset($params['value'])) {
				throw new MissingArgumentException('value');
			}
		} else if (isset($params['attributes'])) {
			if (is_array($params['attributes'])) {
				$params['attributes'] = json_encode($params['attributes']);
			}
		} else {
			throw new MissingArgumentException('attribute_name with value or attributes');
		}

		return $this->post('entity.update', $params);
	}
}
