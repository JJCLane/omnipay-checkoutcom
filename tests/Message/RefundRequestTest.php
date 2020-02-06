<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Tests\TestCase;


class RefundRequestTest extends TestCase
{
    protected $request;

    protected function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'amount' => '12.00',
            'currency' => 'USD',
            'transactionId' => 'my-id',
            'metadata' => [
                'coupon_code' => 1,
            ]
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('ORD-5023-4E89', $response->getTransactionReference());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        //$this->assertFalse($response->isRedirect());
    }

}