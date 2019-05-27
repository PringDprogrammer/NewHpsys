<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walkins', function (Blueprint $table) {
            $table->increments('Wid')->references('order_id')->on('orderitems');
            $table->string('walkin_id');
            $table->date('transdate');
            $table->string('fullname');
            $table->string('discountType')->nullable();
            $table->double('discount', 10, 2)->nullable();
            $table->double('orderTotal', 10, 2);
            $table->double('sumtotal', 10, 2);
            $table->double('cash', 10, 2)->nullable();
            $table->string('cashref')->nullable();
            $table->double('coupon', 10, 2)->nullable();
            $table->string('couponref')->nullable();
            $table->double('phic', 10, 2)->nullable();
            $table->string('phicref')->nullable();
            $table->string('others')->nullable();
            $table->double('othersamount', 10, 2)->nullable();
            $table->string('othersref')->nullable();
            $table->double('payment_total', 10, 2);
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
        Schema::dropIfExists('walkins');
    }
}
