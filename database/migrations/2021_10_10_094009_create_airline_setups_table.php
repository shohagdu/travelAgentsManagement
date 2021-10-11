<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlineSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_setups', function (Blueprint $table) {
            $table->id();
            $table->string('airline_title',200);
            $table->string('country_name',200);
            $table->string('fare',200);
            $table->decimal('commission',10,2);
            $table->decimal('add',10,2);
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
        Schema::dropIfExists('airline_setups');
    }
}
