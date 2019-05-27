<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatients', function (Blueprint $table) {
            $table->increments('Pid')->references('patient_order_id')->on('patientorderitems');
            $table->string('inpatient_id');
            $table->date('dateBirth');
            $table->string('fullname');
            $table->string('suffix')->nullable();
            $table->string('age');
            $table->string('gender');
            $table->string('marital')->nullable();
            $table->string('address')->nullable();
            $table->string('brngy')->nullable();
            $table->string('municipal')->nullable();
            $table->string('province')->nullable();
            $table->string('telNo')->nullable();
            $table->string('celNo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inpatients');
    }
}
