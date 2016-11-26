<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trade extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trade';


    protected $fillable = ['U_id', 'symbol', 'buy_sell', 'price', 'time', 'quantity', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $primaryKey = 't_id';

    public $timestamps = false;
}
