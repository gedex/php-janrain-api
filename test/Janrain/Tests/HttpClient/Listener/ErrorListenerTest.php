<?php

namespace Janrain\Tests\HttpClient;

use Janrain\HttpClient\Listener\ErrorListener;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function shouldPassIfResponseNotHaveErrorStatus()
	{
		$response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
		$response->expects($this->once())
			->method('isClientError')
			->will($this->returnValue(false));

		$listener = new ErrorListener();
		$listener->onRequestError($this->getEventMock($response));
	}

	/**
	 * @test
	 * @expectedException \Janrain\Exception\RuntimeException
	 */
	public function shouldNotPassWhenContentWasNotValidJson()
	{
		$response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
		$response->expects($this->once())
			->method('isClientError')
			->will($this->returnValue(true));
		$response->expects($this->once())
			->method('getBody')
			->will($this->returnValue('fail'));

		$listener = new ErrorListener();
		$listener->onRequestError($this->getEventMock($response));
	}

	/**
	 * @test
	 * @expectedException \Janrain\Exception\ValidationFailedException
	 */
	public function shouldNotPassWhenContentWasValidJsonButStatusIsNotOK()
	{
		$response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
		$response->expects($this->once())
			->method('getBody')
			->will($this->returnValue(json_encode(array('stat' => 'fail'))));

		$listener = new ErrorListener();
		$listener->onRequestError($this->getEventMock($response));
	}

	private function getEventMock($response)
	{
		$mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

		$request = $this->getMockBuilder('Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();

		$request->expects($this->any())
			->method('getResponse')
			->will($this->returnValue($response));

		$mock->expects($this->any())
			->method('offsetGet')
			->will($this->returnValue($request));

		return $mock;
	}
}
