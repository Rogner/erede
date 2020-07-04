<?php

namespace Rogner\Erede\Helper;

use Cagartner\Pagseguro\Payment\PagSeguro;
use Illuminate\Support\Facades\Log;
use Webkul\Sales\Contracts\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;
use function core;

class Helper
{

    protected $orderRepository;

    protected $invoiceRepository;

    protected $refundRepository;

    public function __construct(
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
        RefundRepository $refundRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->refundRepository = $refundRepository;
    }

    public function updateOrder($order)
    {
        $this->invoiceRepository->create($this->prepareInvoiceData($order));
    }

    protected function prepareInvoiceData(Order $order)
    {
        $invoiceData = [
            "order_id" => $order->id,
        ];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    protected function prepareRefundData(\Webkul\Sales\Models\Order $order)
    {
        $refundData = [
            "order_id" => $order->id,
            'adjustment_refund'      => $order->sub_tota,
            'base_adjustment_refund' => $order->base_sub_total,
            'adjustment_fee'         => 0,
            'base_adjustment_fee'    => 0,
            'shipping_amount'        => $order->shipping_invoiced,
            'base_shipping_amount'   => $order->base_shipping_invoiced,
        ];

        foreach ($order->items as $item) {
            $refundData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $refundData;
    }
}
