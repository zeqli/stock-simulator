<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class watchlist extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'watchlist';


    protected $fillable = ['U_id', 'symbol'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;
}
