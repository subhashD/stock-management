<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('hsnSac')->nullable();
            $table->text('desc')->nullable();
            $table->integer('price')->unsigned();
            $table->integer('tax')->unsigned()->default(0);
            $table->integer('selling_price')->unsigned();
            $table->integer('godown_id')->unsigned();
            $table->integer('qty_avail')->unsigned()->default(0);
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
        Schema::dropIfExists('products');
    }
}
