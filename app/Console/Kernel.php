<?php

namespace App\Console;

use App\Models\Order;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $dateNow = Carbon::today()->format('Y-m-d');

            Order::where('payment_status', 'Success')->where('date', $dateNow)->update(['order_status' => 'On Working'])->everyMinute();

            Order::where('payment_status', 'Success')->where('date', '<', $dateNow)->update(['order_status' => 'Finished'])->everyMinute();

            Order::where('payment_status', '!=', 'Success')->where('date', '<', $dateNow)->update(['order_status' => 'Canceled', 'payment_status' => 'Expired'])->everyMinute();

            $orders_finished = Order::where('order_status', 'Finished')->get();

            foreach ($orders_finished as $data) {
                Report::create([
                    'order_id' => $data->id,
                    'name' => $data->full_name,
                    'address' => $data->address,
                    'whatsapp_num' => $data->whatsapp_num,
                    'date' => $data->date,
                    'location' => $data->location,
                    'payment_status' => $data->payment_status,
                    'total_price' => $data->total_price,
                    'unicode' => $data->unicode,
                    'order_status' => $data->order_status,
                    'pricing_name' => 'x',
                    'pricing_type' => 'y',
                ])->everyMinute();
            }

            $orders_canceled = Order::where('order_status', 'Canceled')->where('payment_status', 'Expired')->get();

            foreach ($orders_canceled as $data) {
                Report::create([
                    'order_id' => $data->id,
                    'name' => $data->full_name,
                    'address' => $data->address,
                    'whatsapp_num' => $data->whatsapp_num,
                    'date' => $data->date,
                    'location' => $data->location,
                    'payment_status' => $data->payment_status,
                    'total_price' => $data->total_price,
                    'unicode' => $data->unicode,
                    'order_status' => $data->order_status,
                    'pricing_name' => 'x',
                    'pricing_type' => 'y',
                ])->everyMinute();
            }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
