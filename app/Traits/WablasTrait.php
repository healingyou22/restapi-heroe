<?php

namespace App\Traits;

trait WablasTrait
{
    public static function reminder($order)
    {
        $curl = curl_init();
        $token = "sPSOqif1O0aKOecGP2HyMLEGfqpTv8S0Zbn2JpLTh5eujuDjOMzrHZkYsuu4Du2H";
        $random = true;
        $payload = [
            "data" => [
                [
                    'phone' => '62' . $order->whatsapp_num,
                    'message' => 'HEROE PHOTOGRAPHY
                    
                    EVENT REMINDER
                    Name :' . $order->full_name . '
                    Pricing :' . $order->pricing->pricing_name . '
                    Date :' . $order->date . '
                    Location :' . $order->location . '

                    Notes : Ini adalah pesan satu arah. Jika ada pertanyaan hubungi nomor 08xxxxxxxxx.',
                ]
            ]
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  "https://kudus.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
    }

    public static function scheduleText($order)
    {
        $curl = curl_init();
        $token = "sPSOqif1O0aKOecGP2HyMLEGfqpTv8S0Zbn2JpLTh5eujuDjOMzrHZkYsuu4Du2H";
        $payload = [
            "data" => [
                [
                    'category' => 'text',
                    'phone' => '62' . $order->whatsapp_num,
                    'scheduled_at' => '2022-08-11 11:55:00',
                    'text' => 'Hallo kakak',
                ],
            ]
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  "https://kudus.wablas.com/api/v2/schedule");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }

    public static function payment_confirmation($order)
    {
        $curl = curl_init();
        $token = "sPSOqif1O0aKOecGP2HyMLEGfqpTv8S0Zbn2JpLTh5eujuDjOMzrHZkYsuu4Du2H";
        $random = true;
        $payload = [
            "data" => [
                [
                    'phone' => '62' . $order->whatsapp_num,
                    'message' => 'HEROE PHOTOGRAPHY
                    
                    Order has been confirmed
                    Name :' . $order->full_name . '
                    Pricing :' . $order->pricing->pricing_name . '
                    Address :' . $order->address . '
                    Date :' . $order->date . '
                    Location :' . $order->location . '
                    Total Price :' . $order->total_price . '
                    Payment Status :' . $order->payment_status . '

                    Notes : Ini adalah pesan satu arah. Jika ada pertanyaan hubungi nomor 08xxxxxxxxx.
                    
                    Terima kasih telah melakukan order dari Heroe Photography',
                ]
            ]
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  "https://kudus.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
    }
}
