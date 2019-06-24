<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dr_no');
            $table->string('or_no');
            $table->date('del_date');
            $table->string('itemcode');
            $table->string('itemName');
            $table->string('brandName')->nullable();
            $table->string('itemType');
            $table->string('consignor');
            $table->integer('quantity');
            $table->string('unit');
            $table->double('sellPrice', 10, 2);
            $table->double('unit_cost', 10, 2);
            $table->double('total', 10, 2);
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
        Schema::dropIfExists('inventories');
    }
}
