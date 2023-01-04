<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pricing_name',
        'pricing_type',
        'pricing_desc',
        'pricing_detail_1',
        'pricing_detail_2',
        'pricing_detail_3',
        'pricing_detail_4',
        'pricing_detail_5',
        'pricing_detail_6',
        'pricing_detail_7',
        'pricing_detail_8',
        'pricing_detail_9',
        'pricing_detail_10',
        'pricing_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public static function index()
    {
        return Pricing::select('id', 'pricing_name', 'pricing_type', 'pricing_desc', 'pricing_detail_1', 'pricing_detail_2', 'pricing_detail_3', 'pricing_detail_4', 'pricing_detail_5', 'pricing_detail_6', 'pricing_detail_7', 'pricing_detail_8', 'pricing_detail_9', 'pricing_detail_10', 'pricing_price')->get();
    }

    public static function store($request, $userId)
    {
        return Pricing::create([
            'user_id' => $userId,
            'pricing_name' => $request['pricing_name'],
            'pricing_type' => $request['pricing_type'],
            'pricing_desc' => $request['pricing_desc'],
            'pricing_detail_1' => $request['pricing_detail_1'],
            'pricing_detail_2' => $request['pricing_detail_2'],
            'pricing_detail_3' => $request['pricing_detail_3'],
            'pricing_detail_4' => $request['pricing_detail_4'],
            'pricing_detail_5' => $request['pricing_detail_5'],
            'pricing_detail_6' => $request['pricing_detail_6'],
            'pricing_detail_7' => $request['pricing_detail_7'],
            'pricing_detail_8' => $request['pricing_detail_8'],
            'pricing_detail_9' => $request['pricing_detail_9'],
            'pricing_detail_10' => $request['pricing_detail_10'],
            'pricing_price' => $request['pricing_price']
        ]);
    }

    public static function show($id)
    {
        return Pricing::select('id', 'pricing_name', 'pricing_type', 'pricing_desc', 'pricing_detail_1', 'pricing_detail_2', 'pricing_detail_3', 'pricing_detail_4', 'pricing_detail_5', 'pricing_detail_6', 'pricing_detail_7', 'pricing_detail_8', 'pricing_detail_9', 'pricing_detail_10', 'pricing_price')->where('id', $id)->first();
    }

    public static function updatePricing($request, $id, $userId)
    {
        return Pricing::where('id', $id)->update([
            'user_id' => $userId,
            'pricing_name' => $request['pricing_name'],
            'pricing_type' => $request['pricing_type'],
            'pricing_desc' => $request['pricing_desc'],
            'pricing_detail_1' => $request['pricing_detail_1'],
            'pricing_detail_2' => $request['pricing_detail_2'],
            'pricing_detail_3' => $request['pricing_detail_3'],
            'pricing_detail_4' => $request['pricing_detail_4'],
            'pricing_detail_5' => $request['pricing_detail_5'],
            'pricing_detail_6' => $request['pricing_detail_6'],
            'pricing_detail_7' => $request['pricing_detail_7'],
            'pricing_detail_8' => $request['pricing_detail_8'],
            'pricing_detail_9' => $request['pricing_detail_9'],
            'pricing_detail_10' => $request['pricing_detail_10'],
            'pricing_price' => $request['pricing_price']
        ]);
    }

    public static function destroy($id)
    {
        return Pricing::find($id)->delete();
    }
}
