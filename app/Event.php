<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'date_start', 'date_emd'
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function participant()
    {
        return $this->hasMany('App\Participant');
    }
}
