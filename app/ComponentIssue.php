<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentIssue extends Model
{
    // pivot table for components and isues...
    protected $table = 'component_issue';

    protected $fillable = ['component_id', 'issue_id'];


}
