<?php

namespace Janrain\HttpClient\Listener;

use Janrain\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;

use Janrain\Exception\ErrorException;
use Janrain\Exception\RuntimeException;
use Janrain\Exception\ValidationFailedException;

/**
 * @author Akeda Bagus <admin@gedex.web.id>
 */
class ErrorListener
{
	/**
	 * @var array
	 */
	private $options;

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array())
	{
		$this->options = $options;
	}

	/**
	 * {@inheritDoc}
	 */
	public function onRequestError(Event $event)
	{
		/** @var $request \Guzzle\Http\Message\Request */
		$request  = $event['request'];
		$response = $request->getResponse();
		$content  = ResponseMediator::getContent($response);

		if ($response->isClientError() || $response->isServerError() || (isset($content['stat']) && 'ok' !== strtolower($content['stat']))) {
			$errorMsg = isset($content['error_description']) ? $content['error_description'] : '';
			if (empty($errorMsg) && isset($content['error']['msg'])) {
				$errorMsg = $content['error']['msg'];
			}

			if (is_array($content) && isset($content['stat']) && 'ok' !== strtolower($content['stat'])) {
				throw new ValidationFailedException('Validation Failed: '. $errorMsg, 422);
			}

			throw new RuntimeException($errorMsg ?: $content, $response->getStatusCode());
		}
	}
}
