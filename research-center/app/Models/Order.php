<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_type',
        'user_id',
        'nama',
        'shipping_phonenumber',
        'shipping_postalcode',
        'address',
        'shipping_city',
        'file_path',
        'totalprice',
        'status',
        'ulasan',
        'snap_token',
        'coupon_id',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function coupon()
{
    return $this->belongsTo(Coupon::class);
}
public function events()
{
    return $this->hasMany(Event::class, 'id', 'item_id');
}

public function researchData()
{
    return $this->hasMany(ResearchData::class, 'id', 'item_id');
}



}
