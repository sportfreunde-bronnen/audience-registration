<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use SoftDeletes;

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

    /**
     * Get scannable events only
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScannable($query)
    {
        return $query
            ->whereNull('date_end')
            ->where('date_start', '>=', Carbon::now()->subHours(5)->format('Y-m-d H:i:s'))
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNotNull('date_end')
                    ->where('date_start', '>=', Carbon::now()->subHours(5)->format('Y-m-d H:i:s'))
                    ->where('date_end', '>', Carbon::now()->format('Y-m-d H:i:s'));
            });
    }

    /**
     * Get expired events (after 4 weeks)
     *
     * @param $query
     */
    public function scopeExpired($query)
    {
        return $query
            ->whereNull('date_end')
            ->where('date_start', '<=', Carbon::now()->subDays(28)->format('Y-m-d H:i:s'))
            ->orWhere(function ($query) {
                /** @var Builder $query */
               $query
                   ->whereNotNull('date_end')
                   ->where('date_end', '<=', Carbon::now()->subDays(28)->format('Y-m-d H:i:s'));
            });
    }

}
