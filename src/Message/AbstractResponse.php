<?php
/**
 * CheckoutCom Response
 */

namespace Omnipay\CheckoutCom\Message;

use Omnipay\Common\Message\RequestInterface;

/**
 * CheckoutCom Response
 *
 * This is the response class for all CheckoutCom requests.
 *
 * @see \Omnipay\CheckoutCom\Gateway
 */
class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    protected $data;

    public function __construct(RequestInterface $request, $encodedContent)
    {
        parent::__construct($request, $encodedContent);

        $this->data = json_decode($encodedContent, true);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['reference'])) {
            return $this->data['reference'];
        }

        return null;

    }

    public function getRequestId()
    {
        if (isset($this->data['request_id'])) {
            return $this->data['request_id'];
        }

        return null;
    }

    public function getErrorType()
    {
        if (isset($this->data['error_type'])) {
            return $this->data['error_type'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['errorCode'])) {
            return $this->data['errorCode'] . ': ' . $this->data['message'];
        }

        return null;
    }

    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->data['errorCode']);
    }
}
