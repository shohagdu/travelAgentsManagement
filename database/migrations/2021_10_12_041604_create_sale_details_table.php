<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->integer('airline_id');
            $table->string('fare',200);
            $table->decimal('tax_per',10,2);
            $table->decimal('tax_amount',10,2);
            $table->decimal('total_amount',10,2);
            $table->decimal('commission_per',10,2);
            $table->decimal('commission_amount',10,2);
            $table->decimal('ait_per',10,2);
            $table->decimal('ait_amount',10,2);
            $table->decimal('add_per',10,2);
            $table->decimal('add_amount',10,2);
            $table->decimal('invoice_amount',10,2);
            $table->decimal('discount',10,2);
            $table->decimal('net_amount',10,2);
            $table->tinyInteger('is_active');
            $table->string('created_by',20);
            $table->string('updated_by',20);
            $table->string('created_ip',15);
            $table->string('updated_ip', 15);
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
        Schema::dropIfExists('sale_details');
    }
}
