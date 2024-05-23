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
        'name', 'date_start', 'date_emd', 'date_register_start'
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'date_register_start' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function participant()
    {
        return $this->hasMany('App\Participant');
    }

    public function getRemainingQuota()
    {
        if ($this->quota) {
            return $this->quota - $this->participant()->sum('amount');
        }
        return null;
    }

    public function showRemainingQuota()
    {
        return !is_null($this->quota);
    }

    /**
     * Get scannable events only
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScanable($query)
    {
        return $query
            ->whereNull('date_end')
            ->where('date_start', '>', Carbon::now()->subHours(24)->format('Y-m-d H:i:s'))
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNotNull('date_end')
                    ->where('date_end', '>', Carbon::now()->subHours(5)->format('Y-m-d H:i:s'));
            });
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeOpenForRegistration($query)
    {
        return $query
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNull('date_register_start')
                    ->whereNull('date_end')
                    ->where('date_start', '>=', Carbon::now()->subHours(10)->format('Y-m-d H:i:s'));
            })
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNotNull('date_register_start')
                    ->whereNull('date_end')
                    ->where('date_register_start', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('date_start', '>=', Carbon::now()->subHours(10)->format('Y-m-d H:i:s'));
            })
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNotNull('date_end')
                    ->whereNull('date_register_start')
                    ->where('date_end', '>=', Carbon::now()->format('Y-m-d H:i:s'));
            })
            ->orWhere(function($query) {
                /** @var Builder $query */
                $query
                    ->whereNotNull('date_register_start')
                    ->whereNotNull('date_end')
                    ->where('date_register_start', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->where('date_end', '>=', Carbon::now()->format('Y-m-d H:i:s'));
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

    public function isDartsTournament()
    {
        $dartsTournaments = config('app.darts_tournaments');
        if (null === $dartsTournaments) {
            return false;
        }
        return (in_array($this->id, explode(',', $dartsTournaments)));
    }

}
