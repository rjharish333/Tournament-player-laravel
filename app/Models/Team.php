<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

     public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
