<?php

namespace Janrain\Api\Capture;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class Access extends AbstractApi
{
	/**
	 * Retrieves an `accessToken` for signing in to an application. This token is
	 * valid for 1 hour.
	 *
	 * @param array $params
	 * @link  http://developers.janrain.com/documentation/api-methods/capture/access-codes-and-tokens/getaccesstoken/
	 */
	public function getAccessToken(array $params)
	{
		return $this->post('access/getAccessToken', $params);
	}

	/**
	 * Get an authorization code that can be exchanged for an `access_token` and
	 * a `refresh_token`.
	 *
	 * @param array $params
	 * @link  http://developers.janrain.com/documentation/api-methods/capture/access-codes-and-tokens/getauthorizationcode/
	 */
	public function getAuthorizationCode(array $params)
	{
		if (isset($params['transaction_state'])) {
			$params['transaction_state'] = json_encode($params['transaction_state']);
		}

		return $this->post('access/getAuthorizationCode', $params);
	}

	/**
	 * Gets a creation token which can be used to make API calls without the use
	 * of a client id and secret.
	 *
	 * @param array $params
	 * @link  http://developers.janrain.com/documentation/api-methods/capture/access-codes-and-tokens/getcreationtoken-xml/
	 */
	public function getCreationToken(array $params)
	{
		return $this->post('access/getCreationToken', $params);
	}

	/**
	 * Gets a verification code that can later be used with `useVerificationCode`.
	 * The `useVerificationCode` call sets a time field in an `entity` to the
	 * current time. This is useful for recording timestamps for when an email
	 * address was verified, or similar purposes.
	 *
	 * @param array $params
	 * @link  http://developers.janrain.com/documentation/api-methods/capture/access-codes-and-tokens/getverificationcode/
	 */
	public function getVerificationCode(array $params)
	{
		return $this->post('access/getVerificationCode', $params);
	}

	/**
	 * Uses a verification code to set a time field to the current time. Any
	 * particular verification code can only be used once. This is often used for
	 * items like email verification.
	 *
	 * @param string $verificationCode
	 * @link  http://developers.janrain.com/documentation/api-methods/capture/access-codes-and-tokens/useverificationcode/
	 */
	public function useVerificationCode($verificationCode)
	{
		return $this->post('access/useVerificationCode', array('verification_code' => $verificationCode));
	}
}
