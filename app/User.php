<?php

namespace App;


use App\Models\Video\VideoPlaylist;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    //one user has many timelogs...
    public function timelogs() {

        return $this->hasMany(Timelog::class, 'user_id');
    }

}
