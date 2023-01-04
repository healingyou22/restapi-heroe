<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'address',
        'whatsapp_num',
        'date',
        'location',
        'payment_status',
        'total_price',
        'unicode',
        'order_status',
        'pricing_name',
        'pricing_type'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function index()
    {
        return Report::select('id', 'order_id', 'name', 'address', 'whatsapp_num', 'date', 'location', 'payment_status', 'total_price', 'unicode', 'order_status')->get();
    }

    public static function show($id)
    {
        return Report::select('id', 'order_id', 'name', 'address', 'whatsapp_num', 'date', 'location', 'payment_status', 'total_price', 'unicode', 'order_status')->where('id', $id)->first();
    }

    public static function store($request)
    {
        return Report::create([
            'order_id' => $request['id'],
            'name' => $request['full_name'],
            'address' => $request['address'],
            'whatsapp_num' => $request['whatsapp_num'],
            'date' => $request['date'],
            'location' => $request['location'],
            'payment_status' => $request['payment_status'],
            'total_price' => $request['total_price'],
            'unicode' => $request['unicode'],
            'order_status' => $request['order_status'],
            'pricing_name' => 'x',
            'pricing_type' => 'y',
        ]);
    }
}
