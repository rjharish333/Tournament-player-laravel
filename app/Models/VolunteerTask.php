<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'activity_volunteer_tasks';
}
