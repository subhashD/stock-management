<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 10);
            $table->string('estimate_no', 191)->nullable();
            $table->string('ref_no', 191)->nullable();
            $table->date('estimate_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('items', 191);
            $table->string('qtys', 191);
            $table->string('price', 191);
            $table->string('tax', 191);
            $table->text('description', 65535)->nullable();
            $table->string('gst', 191)->nullable();
            $table->string('discount', 191)->nullable();
            $table->string('adjustment', 191)->nullable();
            $table->text('terms_condition', 65535)->nullable();
            $table->string('total', 191);
            $table->string('status', 10)->default('pending');
            $table->string('state', 30)->nullable();
            $table->string('pdf_gen', 256)->nullable();
            $table->text('mail_body', 65535)->nullable();
            $table->string('mail_subject')->nullable();
            $table->string('created_by', 191);
            $table->date('send_date')->nullable();
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
        Schema::dropIfExists('estimates');
    }
}
