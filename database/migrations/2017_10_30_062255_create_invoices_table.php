<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notax_invoice', 191)->unique()->nullable();
            $table->string('tax_invoice', 191)->unique()->nullable();
            $table->string('client_id', 191);
            $table->string('state')->nullable();
            $table->string('sales_person', 191)->nullable();
            $table->string('invoice_date', 191);
            $table->string('ref_no', 191)->nullable();
            $table->string('due_date', 191);
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
            $table->string('pdf_gen', 256)->nullable();
            $table->string('method', 191)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
