<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSymbol extends Model
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_symbols';


    protected $fillable = ['symbol', 'name', 'ipo_year', 'sector', 'industry'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName(){
        return 'symbol';
    }
}
