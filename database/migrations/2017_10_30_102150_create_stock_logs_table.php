<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->integer('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            $table->integer('godown_id')->unsigned()->nullable();
            $table->foreign('godown_id')->references('id')->on('godowns')->onDelete('cascade');

            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('client')->onDelete('cascade');

            $table->integer('qty')->unsigned();
            $table->string('type');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('stock_logs');
    }
}
