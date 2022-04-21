<?php
namespace Omnipay\Epayco\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Epayco Response
 *
 * This is the response class for all Epayco requests.
 *
 * @see \Omnipay\Epayco\Gateway
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    protected $liveCheckoutEndpoint = 'https://www.paypal.com/cgi-bin/webscr';
    protected $testCheckoutEndpoint = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getCheckoutEndpoint().'?'.http_build_query($this->getRedirectQueryParameters(), '', '&');
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return $this->data ?? null;
    }

    public function getTransactionReference()
    {
        return $this->data ?? null;
    }

    protected function getRedirectQueryParameters()
    {
        return $this->getTransactionReference();
        /*return array(
            'cmd' => '_express-checkout',
            'useraction' => 'commit',
            'token' => $this->getTransactionReference(),
            'p_keyy' => $this->getRequest()->getData()
        );*/
    }

    public function getTransactionId()
    {
        return $this->data['reference'] ?? null;
    }

    public function getCardReference()
    {
        return $this->data['reference'] ?? null;
    }

    public function getMessage()
    {
        return $this->data['message'] ?? null;
    }

    protected function getCheckoutEndpoint()
    {
        return $this->getRequest()->getTestMode() ? $this->testCheckoutEndpoint : $this->liveCheckoutEndpoint;
    }
}
