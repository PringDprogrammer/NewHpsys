<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additems', function (Blueprint $table) {
            $table->increments('wId');
            $table->string('itemcode');
            $table->string('itemName');
            $table->string('itemType');
            $table->integer('quantity');
            $table->double('sellPrice', 10, 2);
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
        Schema::dropIfExists('additems');
    }
}
