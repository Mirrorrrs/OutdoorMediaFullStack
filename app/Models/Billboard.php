<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function setNewProperties($properties){
        $properties = collect($properties);
        foreach ($properties->keys() as $key){
            $this[$key]=$properties[$key];
        }

        $this->save();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class,"billboard_id","id");
    }

    public function applications()
    {
        return $this->hasMany(Application::class,"billboard_id","id");
    }
}
