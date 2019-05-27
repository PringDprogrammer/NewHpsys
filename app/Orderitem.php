<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $table = 'orderitems';

    public function walkin()
    {
    	$this->belongsTo('App/Walkin', 'walkin_id');
    }
}
