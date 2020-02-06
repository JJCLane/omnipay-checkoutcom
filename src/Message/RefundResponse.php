<?php


namespace Omnipay\CheckoutCom\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class RefundResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $redirectEndpoint = null;

    public function isSuccessful()
    {
        if (!empty($this->data['errorCode'])) {
            return false;
        }

        if (!empty($this->data['status'])) {
            return ($this->data['status'] == 'Refunded');
        }

        return false;
    }

    public function isRedirect()
    {
        return !isset($this->data['errorCode']);
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['errorCode'])) {
            return $this->data['errorCode'] . ': ' . $this->data['message'];
        }

        if (!$this->isSuccessful() && isset($this->data['responseCode'])) {
            return $this->data['responseCode'] . ': ' . $this->data['responseMessage'];
        }

        return null;
    }

    public function getRedirectData()
    {
        return $this->getData();
    }
}