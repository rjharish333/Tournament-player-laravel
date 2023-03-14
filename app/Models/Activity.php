<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'activities';

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type');
    }

    public function selectionType()
    {
        return $this->belongsTo(SelectionType::class, 'selection_type');
    }


}
