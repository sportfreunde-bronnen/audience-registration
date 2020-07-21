<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'name', 'last_name', 'email', 'phone', 'amount'
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function event()
    {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
}
