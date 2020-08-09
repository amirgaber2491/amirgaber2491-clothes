<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['total_sales', 'dis_sales', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function image()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
