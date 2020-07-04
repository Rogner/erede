<?php

namespace Rogner\Erede\Http\Controllers;

use Exception;
use Rogner\Erede\Payment\Erede;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Rogner\Erede\Helper\Helper;
use Webkul\Sales\Repositories\InvoiceRepository;

class EredeController extends Controller
{
    protected $orderRepository;

    protected $invoiceRepository;

    protected $helper;

    public function __construct(
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
        Helper $helper
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->helper = $helper;
    }

    public function redirect()
    {
        $cart = Cart::getCart();

        return view('erede::redirect')->with('cart', $cart);;
    }

    public function pay(Request $request)
    {

        $messages = [
            'name.required'     => __('Nome do Titular') . __(' não preenchido!'),
            'cardnumber.required'        => __('Número do Cartão') . __(' não preenchido!'),
            'expirationdate.required'  => __('Validade') . __(' não preenchido!'),
            'securitycode.required' => __('Código de Segurança') . __(' não preenchido!'),
        ];

        $request->validate([
            'name' => 'required',
            'cardnumber' => 'required',
            'expirationdate' => 'required',
            'securitycode' => 'required',
        ], $messages);

        $erede = new Erede();

        $transaction = null;

        try {
            $transaction = $erede->init($request);
        } catch (Exception $e) {
            Log::error($e);
            //return Redirect::back()->withErrors(['msg' => '* Preencha corretamente os dados do Cartão de Crédito']);
        }

        $order = $this->orderRepository->create(Cart::prepareDataForOrder());


        if ($transaction != null && $transaction->getReturnCode() == '00') {

            $this->helper->updateOrder($order);
        }

        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
    }
}
