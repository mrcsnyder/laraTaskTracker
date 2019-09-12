<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    protected $table = 'timelogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_id', 'user_id', 'seconds_logged',
    ];


    //one timelog belongs to a user...
    public function users()
    {
        return $this->belongsToMany(User::class, 'timelogs', 'user_id');
    }


}
