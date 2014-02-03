<?php

namespace Janrain\Tests\HttpClient;

use Guzzle\Http\Message\Request;

use Janrain\Client;
use Janrain\HttpClient\Listener\AuthListener;

class AuthListenerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 * @expectedException \Janrain\Exception\MissingArgumentException
	 */
	public function shouldHaveKnownOptions()
	{
		$request = $this->getMock('Guzzle\Http\Message\RequestInterface');
		$request->expects($this->never())->method('setUrl');

		$listener = new AuthListener(array());
		$listener->onRequestBeforeSend($this->getEventMock($request));
	}

	/**
	 * @test
	 */
	public function shouldSetAccessTokenInUrlIfProvidedInOptions()
	{
		$request = new Request('POST', '/resource');

		$listener = new AuthListener(array(
			'access_token' => 'xxx',
		));
		$listener->onRequestBeforeSend($this->getEventMock($request));

		$this->assertEquals('/resource?access_token=xxx&token=xxx', $request->getUrl());
	}

	/**
	 * @test
	 */
	public function shouldSetClientIdAndSecretInUrlIfProvidedInOptions()
	{
		$request = new Request('POST', '/resource');

		$listener = new AuthListener(array(
			'client_id'     => 'x',
			'client_secret' => 'y',
		));
		$listener->onRequestBeforeSend($this->getEventMock($request));

		$this->assertEquals('/resource?client_id=x&client_secret=y', $request->getUrl());
	}

	/**
	 * @test
	 */
	public function shouldSetApiKeyInUrlIfProvidedInOptions()
	{
		$request = new Request('POST', '/resource');

		$listener = new AuthListener(array(
			'client_id'     => 'x',
			'client_secret' => 'y',
			'api_key'       => 'xxx',
		));
		$listener->onRequestBeforeSend($this->getEventMock($request));

		$this->assertEquals('/resource?client_id=x&client_secret=y&apiKey=xxx', $request->getUrl());
	}

	/**
	 * @test
	 */
	public function shouldSetPartnerKeyInUrlIfProvidedInOptions()
	{
		$request = new Request('POST', '/resource');

		$listener = new AuthListener(array(
			'client_id'     => 'x',
			'client_secret' => 'y',
			'partner_key'   => 'xxx',
		));
		$listener->onRequestBeforeSend($this->getEventMock($request));

		$this->assertEquals('/resource?client_id=x&client_secret=y&partnerKey=xxx', $request->getUrl());
	}

	public function getEventMock($request = null)
	{
		$mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

		if ($request) {
			$mock->expects($this->any())
				->method('offsetGet')
				->will($this->returnValue($request));
		}

		return $mock;
	}
}
