<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Walkin extends Model
{
    protected $table = 'walkins';

    public function orderitem()
    {
    	$this->hasMany('App/Orderitem', 'order_id');
    }
}
