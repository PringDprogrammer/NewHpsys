<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderitems', function (Blueprint $table) {
            $table->increments('orderId')->references('itemcode')->on('inventories');
            $table->string('order_id');
            $table->string('itemcode')->nullable();
            $table->string('itemName')->nullable();
            $table->string('itemType')->nullable();
            $table->string('consignor')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('sellPrice', 10, 2)->nullable();
            $table->double('itemTotal', 10, 2)->nullable();
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
        Schema::dropIfExists('orderitems');
    }
}
