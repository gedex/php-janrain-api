<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Webhooks extends AbstractApi
{
	public function add(array $params)
	{
		foreach (array('callback', 'event_type', 'entity_type') as $required) {
			if (!isset($params[$required])) {
				throw new MissingArgumentException($required);
			}
		}

		return $this->post('webhooks/add', $params);
	}

	public function delete($id)
	{
		$params = array('uuid' => $id);
		return $this->post('webhooks/delete', $params);
	}

	public function find($id)
	{
		$params = array('uuid' => $id);
		return $this->post('webhooks/find', $params);
	}

	public function getList()
	{
		return $this->post('webhooks/list');
	}

	/**
	 * Alist for getList.
	 */
	public function all()
	{
		return $this->getList();
	}


	public function update($id, array $params)
	{
		$params['uuid'] = $id;
		return $this->post('webhooks/update', $params);
	}
}
