<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'image', 'title'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute($value)
    {
        return Storage::url("images/" . $value);
    }

    public static function index()
    {
        return Gallery::select('id', 'image', 'title')->get();
    }

    public static function store($imageFullName, $title, $userId)
    {
        return Gallery::create([
            'user_id' => $userId,
            'image' => $imageFullName,
            'title' => $title,
        ]);
    }

    public static function destroy($id)
    {
        return Gallery::find($id)->delete();
    }
}
