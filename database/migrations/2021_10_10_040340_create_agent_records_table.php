<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_records', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('mobile', 15);
            $table->string('email', 200);
            $table->string('company_name', 200);
            $table->text('address');
            $table->integer('country');
            $table->integer('city');
            $table->integer('zip_code');
            $table->string('office_phone', 25);
            $table->decimal('opening_balance',10,2);
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
        Schema::dropIfExists('agent_records');
    }
}
