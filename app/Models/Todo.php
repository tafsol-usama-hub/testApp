<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function CompletedBy()
    {
        return $this->belongsTo('App\Models\User','completed_by');
    }

    public function CreatedBy()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function getTimezone(){

        $ip = env('APP_ENV') == 'local' ? env('DEMO_IP') : request()->ip();
        $ipData = Cache::get($ip);

        return $ipData->timezone;
    }
}
