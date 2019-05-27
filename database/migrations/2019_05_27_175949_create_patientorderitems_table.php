<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientorderitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patientorderitems', function (Blueprint $table) {
            $table->increments('orderId')->references('itemcode')->on('inventories');
            $table->string('patient_order_id');
            $table->string('reference_no');
            $table->date('transdate');
            $table->string('itemcode');
            $table->string('itemName');
            $table->string('itemType');
            $table->string('consignor');
            $table->string('disc_type')->nullable();
            $table->string('disc_ref')->nullable();
            $table->integer('quantity');
            $table->double('sellPrice', 10, 2);
            $table->double('itemTotal', 10, 2);
            $table->double('orderTotal', 10, 2);
            $table->double('disc_amount', 10, 2);
            $table->double('grnd_total', 10, 2);
            $table->string('cash_ref')->nullable();
            $table->double('cash_amount', 10, 2)->nullable();
            $table->string('coupon_ref')->nullable();
            $table->double('coupon_amount', 10, 2)->nullable();
            $table->string('phic_ref')->nullable();
            $table->double('phic_amount', 10, 2)->nullable();
            $table->string('others_ref')->nullable();
            $table->string('others_desc')->nullable();
            $table->double('others_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('patientorderitems');
    }
}
