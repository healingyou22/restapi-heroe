<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp_num',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pricing()
    {
        return $this->hasMany(Pricing::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public static function checkEmail($user)
    {
        return User::where('email', $user)->first();
    }

    public static function index()
    {
        return User::select('id', 'name', 'email', 'whatsapp_num', 'role')->get();
    }

    public static function store($request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'whatsapp_num' => $request['whatsapp_num'],
            'role' => $request['role'] ?? "klien"
        ]);
    }

    public static function show($id)
    {
        return User::select('name', 'email', 'role', 'whatsapp_num')->where('id', $id)->first();
    }

    public static function updateUser($request, $id)
    {
        return User::where('id', $id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'whatsapp_num' => $request['whatsapp_num']
        ]);
    }

    public static function destroy($id)
    {
        return User::find($id)->delete();
    }
}
