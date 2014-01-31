<?php

namespace Janrain\Api\Partner;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Admin extends AbstractApi
{

	/**
	 * Adds an adminstrator to the RP.
	 *
	 * @param string $email  The email associated with the admin user
	 * @param string $format Either 'json' or 'xml'
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/admin/add/
	 */
	public function add($email, $format = 'json')
	{
		return $this->post('admin/add', compact('email', 'format'));
	}

	/**
	 * Deletes an admin user on an RP.
	 *
	 * @param string $email  The email associated with the admin user
	 * @param string $format Either 'json' or 'xml'
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/admin/delete-2/
	 */
	public function delete($email, $format = 'json')
	{
		return $this->post('admin/delete', compact('email', 'format'));
	}

	/**
	 * Returns all admin users currently assigned to the RP. It also lists the
	 * email associated with each admin user, and if they are subscribed to
	 * notifications.
	 *
	 * @param string $format Either 'json' or 'xml'
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/partner/admin/get/
	 */
	public function get($format = 'json')
	{
		return $this->post('admin/get', compact('format'));
	}
}
