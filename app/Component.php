<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'components';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    //many components have many issues...
    public function issues()
    {
        return $this->belongsToMany(Issue::class, 'component_issue','component_id');

    }

}
