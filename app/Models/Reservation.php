<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function billboard()
    {
        return $this->belongsTo(Billboard::class,"id", "billboard_id");
    }
}
