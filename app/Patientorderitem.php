<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patientorderitem extends Model
{
   	protected $guarded = [];
    protected $table = 'patientorderitems';

	public function inPatient()
    {
    	$this->belongsTo('App\InPatient', 'inpatient_id');
    }
}
