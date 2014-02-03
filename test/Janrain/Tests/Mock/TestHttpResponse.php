<?php

namespace Janrain\Tests\Mock;

use Guzzle\Http\Message\Response;

class TestResponse extends Response
{
	protected $loopCount;

	protected $content;

	public function __construct($loopCount, array $content = array())
	{
		$this->loopCount = $loopCount;
		$this->content   = $content;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getBody($asString = false)
	{
		return json_encode($this->content);
	}
}
