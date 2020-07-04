<?php

namespace Rogner\Erede\Payment;

use Exception;
use Illuminate\Support\Facades\Log;
use Webkul\Payment\Payment\Payment;
use Webkul\Checkout\Facades\Cart;

use function core;

class Erede extends Payment
{
    const CONFIG_PV = 'sales.paymentmethods.erede.pv';

    const CONFIG_TOKEN = 'sales.paymentmethods.erede.token';

    const CONFIG_SANDBOX = 'sales.paymentmethods.erede.sandbox';

    const CONFIG_DEBUG = 'sales.paymentmethods.erede.debug';

    protected $code = 'erede';

    protected $sandbox = false;

    protected $environment = 'production';

    protected $pv;

    protected $token;

    public function __construct()
    {
        $this->pv = core()->getConfigData(self::CONFIG_PV);
        $this->token = core()->getConfigData(self::CONFIG_TOKEN);

        if (core()->getConfigData(self::CONFIG_SANDBOX)) {
            $this->sandbox = true;
            $this->environment = 'sandbox';
        }
    }

    public function init($request)
    {
        $cart = Cart::getCart();

        if (!$this->pv || !$this->token) {
            throw new Exception('E-Rede: To use this payment method you need to inform the token and pv account of E-Rede account.');
        }

        if ($this->sandbox == true) {
            $store = new \Rede\Store($this->pv, $this->token, \Rede\Environment::sandbox());
        } else {
            $store = new \Rede\Store($this->pv, $this->token, \Rede\Environment::production());
        }

        list($mes, $ano) = explode('/', $request->expirationdate);

        $transaction = (new \Rede\Transaction(floatval($cart->grand_total), 'carrinhos' . $cart->id))->setCard(
            preg_replace('/[ -]+/', '', $request->cardnumber),
            $request->securitycode,
            $mes,
            $ano,
            $request->name,
            $request->kind
        );

        $transaction = (new \Rede\eRede($store))->create($transaction);

        return $transaction;
    }

    public function getRedirectUrl()
    {
        return route('erede.redirect');
    }
}
