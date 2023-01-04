<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\Pricing;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $countOrder = count(Order::all());
        $countGallery = count(Gallery::all());
        $countPricing = count(Pricing::all());
        $countUser = count(User::all());
        $countReport = count(Report::all());

        $response = [
            'message' => 'get count all data!',
            'data' => [
                'order' => $countOrder,
                'gallery' => $countGallery,
                'pricing' => $countPricing,
                'user' => $countUser,
                'report' => $countReport,
            ]
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function getEvents()
    {
        $getEvents = Order::where('order_status', '!=', 'Canceled')->where('order_status', '!=', 'Finished')->where('payment_status', '=', 'Success')->get();

        $events = [];

        foreach ($getEvents as $values) {
            $event = [];
            // $startTime = Carbon::parse($values->start_date)->format("Y-m-d H:s");
            // $endTime = Carbon::parse($values->end_date)->format("Y-m-d H:s");
            // $startTime = Carbon::parse($startTime)->timezone("Asia/Jakarta");
            // $endTime = Carbon::parse($endTime)->timezone("Asia/Jakarta");

            // $values->start_date = $startTime;
            // $values->end_date = $endTime;

            // $event['id'] = $values->id;
            // $event['title'] = $values->event_name;
            // $event['start'] = $values->start_date;
            // $event['end'] = $values->end_date;
            // $event['allDay'] = false;

            $eventTime = Carbon::parse($values->date)->format("Y-m-d H:s");
            $eventTime = Carbon::parse($eventTime)->timezone("Asia/Jakarta");

            $values->date = $eventTime;

            $event['id'] = $values->id;
            $event['title'] = $values->location;
            $event['start'] = $values->date;
            $event['end'] = $values->date;
            // $event['allDay'] = false;

            $events[] = $event;
        }

        return response()->json($events);
    }
}
