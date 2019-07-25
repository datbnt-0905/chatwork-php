<?php

use SunAsterisk\Chatwork\Chatwork;
use SunAsterisk\Chatwork\Endpoints\IncomingRequests;

class IncomingRequestsTest extends TestCase
{
    protected $response;
    protected $requestId;

    protected function setUp(): void
    {
        $response = $this->getMockResponse('incomingrequests');
        $resquestId = $this->response['requestId'];
    }

    public function testGetIncomingRequests()
    {
        /** @var Chatwork $api */
        $api = m::mock(Chatwork::class);
        $api->shouldReceive('get')
            ->with('incoming_requests')
            ->andReturns($this->response['incomingrequests']);

        $incomingrequests = new IncomingRequests($api);

        $this->assertEquals($this->response['incomingrequests'], $incomingrequests->getIncomingRequests());
    }

    public function testAcceptContactRequest()
    {
        /** @var Chatwork $api */
        $api = $this->getAPIMock();
        $api->shouldReceive('put')
            ->with('incoming_requests/123')
            ->andReturns(['response']);

        $incomingrequests = new IncomingRequests($api);

        $this->assertEquals(['response'], $incomingrequests->accept(123));
    }

    public function testRejectContactRequest()
    {
        /** @var Chatwork $api */
        $api = $this->getAPIMock();
        $api->shouldReceive('delete')
            ->with('incoming_requests/123')
            ->andReturns(['response']);

        $incomingrequests = new IncomingRequests($api);

        $this->assertEquals(['response'], $incomingrequests->reject(123));
    }
}
