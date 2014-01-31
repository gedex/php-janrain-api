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

	public function create(array $params)
	{
		if (!isset($params['attributes'])) {
			throw new MissingArgumentException('attributes');
		}

		if (!is_array($params['attributes'])) {
			throw new InvalidArgumentException('Invalid Argument: attributes must be passed as array');
		}
		$params['attributes'] = json_encode($params['attributes']);

		return $this->post('entity.create', $params);
	}

	public function bulkCreate(array $params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}

		if (!isset($params['all_attributes'])) {
			throw new MissingArgumentException('all_attributes');
		}
		if (!is_array($params['all_attributes'])) {
			throw new InvalidArgumentException('Invalid Argument: all_attributes must be passed as array');
		}
		$params['all_attributes'] = json_encode($params['all_attributes']);

		return $this->post('entity.bulkCreate', $params);
	}

	/**
	 * Default by UUID.
	 */
	public function delete($uuid, array $params = array())
	{
		$params['uuid'] = $uuid;
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}

		return $this->_del($params);
	}

	public function deleteById($id, array $params = array())
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

	public function bulkDelete(array $params)
	{
		if (!isset($params['type_name'])) {
			throw new MissingArgumentException('type_name');
		}

		if (!isset($params['filter'])) {
			throw new MissingArgumentException('filter');
		}

		return $this->post('entity.bulkDelete', $params);
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

	/**
	 * @param string $entityType The entityType of entity
	 * @param bool   $commit     Must be set to true to purge the data
	 */
	public function purge($entityType, $commit = false)
	{
		$params = array('type_name' => $entityType, 'commit' => $commit);

		return $this->post('entity.purge', $params);
	}

	/**
	 * Replace part of an entity by UUID.
	 */
	public function replace($uuid, array $params)
	{
		$params['uuid'] = $uuid;

		return $this->_replace($params);
	}

	/**
	 * Replace part of an entity by ID.
	 */
	public function replaceById($id, array $params)
	{
		$params['id'] = $id;

		return $this->_replace($params);
	}

	/**
	 * Replace part of an entity by attribute.
	 */
	public function replaceByAttribute($attributeKey, $attributeValue, array $params)
	{
		$params['key_attribute'] = $attributeKey;
		$params['key_value']     = "'{$attributeValue}'"; // String values need to be enclosed in quotes

		return $this->_replace($params);
	}

	public function _replace(array $params)
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

		return $this->post('entity.replace', $params);
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

		return $this->_update($params);
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
