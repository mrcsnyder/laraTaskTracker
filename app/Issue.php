<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'components',
    ];

//    //tells Eloquent on db fetch to convert the components value(s) to an array...
//    protected $casts = [
//        'components' => 'array'
//    ];


    //one issue can have many timelogs...
    public function timelogs() {

        return $this->hasMany(Timelog::class, 'issue_id');

    }


    //many issues have many components...
    public function components()
    {
        return $this->belongsToMany(Component::class, 'component_issue','issue_id');

    }




}
