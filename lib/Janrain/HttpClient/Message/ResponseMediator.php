<?php

namespace Janrain\HttpClient\Message;

use Guzzle\Http\Message\Response;

class ResponseMediator
{
	public static function getContent(Response $response)
	{
		$body    = $response->getBody(true);
		$content = json_decode($body, true);

		if (JSON_ERROR_NONE !== json_last_error()) {
			return $body;
		}

		return $content;
	}
}
