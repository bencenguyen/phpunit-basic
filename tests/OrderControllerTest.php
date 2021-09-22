<?php

namespace Tests;

use App\CreateOrderRequest;
use App\OrderController;
use App\OrderService;
use PHPUnit\Framework\TestCase;

class OrderControllerTest extends TestCase
{

    private $underTest;

    private $mockService;

    public function setUp(): void
    {
        $this->mockService = $this->createMock(OrderService::class);
        $this->underTest   = new OrderController($this->mockService);
    }

    /**
     *  @test
     */
    public function it_should_return_fail_when_request_is_not_valid()
    {
        $mockRequest = $this->createMock(CreateOrderRequest::class);
        $mockRequest->method("isValid")->willReturn(false);

        $actual = $this->underTest->placeOrder($mockRequest);

        $this->assertEquals($actual, "fail");
    }


    /**
     *  @test
     */
    public function it_should_return_success_when_request_is_valid()
    {
        $mockRequest = $this->createMock(CreateOrderRequest::class);
        $mockRequest->method("isValid")->willReturn(true);

        $actual = $this->underTest->placeOrder($mockRequest); 

        $this->assertEquals($actual, "success");
    }

    /**
     *  @test
     */
    public function it_should_call_service_when_request_is_valid()
    {
        $mockRequest = $this->createMock(CreateOrderRequest::class);
        $mockRequest->method("isValid")->willReturn(true);
        $this->mockService->expects($this->once())->method("placeORder")->with($mockRequest);

        $this->underTest->placeOrder($mockRequest); 

    }
}