<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InPatient extends Model
{
    protected $guarded = [];
    protected $table = 'inpatients';

    public function patientorderitem()
    {
    	$this->hasMany('App\Patientorderitem', 'patient_order_id');
    }
}
