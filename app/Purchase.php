<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['total_purchases', 'dis_purchases', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function images()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
