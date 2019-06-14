<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemlists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('itemcode');
            $table->string('itemName');
            $table->string('brandName')->nullable();
            $table->string('itemType');
            $table->string('consignor');
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
        Schema::dropIfExists('itemlists');
    }
}
