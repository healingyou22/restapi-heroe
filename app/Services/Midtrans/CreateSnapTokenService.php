<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order, $unicode;

    public function __construct($order, $unicode)
    {
        parent::__construct();

        $this->order = $order;
        $this->unicode = $unicode;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->unicode,
                'gross_amount' => $this->order['total_price'],
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $this->order['total_price'],
                    'quantity' => 1,
                    'name' => $this->order['pricing_id'],
                ],
            ],
            'customer_details' => [
                'first_name' => $this->order['full_name'],
                'email' => 'mulyosyahidin95@gmail.com',
                'phone' => $this->order['whatsapp_num'],
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
