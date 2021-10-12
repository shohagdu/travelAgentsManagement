<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_category_id');
            $table->integer('agent_id');
            $table->decimal('sale_amount',10,2);
            $table->decimal('discount',10,2);
            $table->decimal('refund_amount',10,2);
            $table->decimal('amount',10,2);
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
        Schema::dropIfExists('sales');
    }
}
