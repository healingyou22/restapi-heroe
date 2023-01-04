<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pricing_id',
        'full_name',
        'address',
        'whatsapp_num',
        'date',
        'location',
        'total_price',
        'payment_status',
        'unicode',
        'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pricing()
    {
        return $this->belongsTo(Pricing::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public static function index()
    {
        return Order::with('pricing')->select('id', 'pricing_id', 'full_name', 'address', 'whatsapp_num', 'date', 'location', 'total_price', 'payment_status', 'unicode', 'order_status', 'snap_token')->orderBy('date', 'asc')->get();
    }

    public static function show($id)
    {
        // return Order::select('id', 'pricing_id', 'full_name', 'address', 'whatsapp_num', 'date', 'location', 'total_price', 'payment_status', 'unicode', 'order_status', 'snap_token')->with('pricing')->where('id', $id)->first();

        return Order::with('pricing')->where('id', $id)->first();
    }

    public static function store($request, $snapToken, $unicode, $userId)
    {
        return Order::create([
            'user_id' => $userId,
            'pricing_id' => $request['pricing_id'],
            'full_name' => $request['full_name'],
            'address' => $request['address'],
            'whatsapp_num' => $request['whatsapp_num'],
            'date' => $request['date'],
            'location' => $request['location'],
            'total_price' => $request['total_price'],
            'snap_token' => $snapToken,
            'unicode' => $unicode
        ]);
    }

    public static function cancel($id)
    {
        return Order::where('id', $id)->update([
            'order_status' => 'Canceled',
            'payment_status' => 'Canceled'
        ]);
    }

    public static function list($userId)
    {
        return Order::select('id', 'pricing_id', 'full_name', 'address', 'whatsapp_num', 'date', 'location', 'total_price', 'payment_status', 'unicode', 'order_status')->with('pricing')->where('user_id', $userId)->get();
    }
}
