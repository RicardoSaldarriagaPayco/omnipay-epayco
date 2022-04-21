<?php
namespace Omnipay\Epayco\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Epayco Authorize/Purchase Request
 *
 * This is the request that will be called for any transaction which submits a credit card,
 * including `authorize` and `purchase`
 */
class CreditCardRequest extends AbstractRequest
{
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'returnUrl', 'cancelUrl');
        $data = $this->getBaseData();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['transactionId'] = $this->getTransactionId();
        $data['description'] = $this->getDescription();
        $data['retururl'] = $this->getReturnUrl();
        $data['cancelurl'] = $this->getCancelUrl();
        $data['notifyUrl'] = $this->getNotifyUrl();
        $data['test'] = $this->getTestMode();

        return $data;
    }

    public function sendData($data)
    {
        $data['reference'] = $data['transactionId'] ?? uniqid();
        $data['success'] = true;
        $data['message'] = $data['success'] ? 'Success' : 'Failure';

        return $this->response = new Response($this, $data);
    }

    protected function getBaseData()
    {
        $data = array();
        $data['user'] = $this->getUsername();
        $data['password'] = $this->getPassword();
        $data['siganture'] = $this->getSignature();

        return $data;
    }
}
