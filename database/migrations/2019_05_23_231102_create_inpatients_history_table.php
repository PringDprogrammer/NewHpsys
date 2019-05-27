<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatients_history', function (Blueprint $table) {
            $table->increments('historyID');
            $table->string('transaction_no');
            $table->string('patientID');
            $table->string('gname')->nullable();
            $table->string('grelation')->nullable();
            $table->string('gcontact')->nullable();
            $table->string('gaddress')->nullable();
            $table->string('bp');
            $table->string('temp');
            $table->string('pulse_rate');
            $table->string('pat_categ');
            $table->string('pat_type');
            $table->string('doctor');
            $table->string('room');
            $table->string('remarks');
            $table->string('finaldiagnosis')->nullable();
            $table->date('releasedDate')->nullable();
            $table->string('releaseBy')->nullable();
            $table->string('status')->nullable();
            $table->string('pay_status')->nullable();
            $table->date('date_settled')->nullable();
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
        Schema::dropIfExists('inpatients_history');
    }
}
