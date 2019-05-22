<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'year',
        'comment',
    ];
}
