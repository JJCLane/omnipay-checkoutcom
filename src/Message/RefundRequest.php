<?php

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Common\Message\ResponseInterface;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        return [
            'amount' => $this->getAmount(),
            'reference' => $this->getTransactionReference(),
            'metadata' => $this->getMetadata(),
        ];
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);

        return $this->response = new PurchaseResponse($this, json_encode($httpResponse));
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getTransactionReference() . '/refunds';
    }
}