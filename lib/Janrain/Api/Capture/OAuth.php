<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class OAuth extends AbstractApi
{
	public function authNative(array $params)
	{
		return $this->post('oauth/auth_native', $params);
	}

	public function authNativeTraditional(array $params)
	{
		return $this->post('oauth/auth_native_traditional', $params);
	}

	public function forgotPasswordNative(array $params)
	{
		return $this->post('oauth/forgot_password_native', $params);
	}

	public function linkAccountNative(array $params)
	{
		return $this->post('oauth/link_account_native', $params);
	}

	public function registerNative(array $params)
	{
		return $this->post('oauth/register_native', $params);
	}

	public function registerNativeTraditional(array $params)
	{
		return $this->post('oauth/register_native_traditional', $params);
	}

	public function token(array $params)
	{
		return $this->post('oauth/token', $params);
	}

	public function verifyEmailNative(array $params)
	{
		return $this->post('oauth/verify_email_native', $params);
	}
}
