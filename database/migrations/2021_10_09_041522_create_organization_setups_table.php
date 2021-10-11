<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_setups', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->text('address');
            $table->string('mobile', 15);
            $table->string('email', 200);
            $table->string('telephone',50);
            $table->string('website_address', 250);
            $table->string('logo', 250);
            $table->string('templete_logo',250);
            $table->string('favicon', 250);
            $table->string('footer_text');
            $table->string('time_zone');
            $table->string('currency');
            $table->string('tradelicense_no', 50);
            $table->string('vat_no', 50);
            $table->string('per_invoice_deduction_amount');
            $table->decimal('tax_amount',10,2);
            $table->decimal('ait',10,2);
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
        Schema::dropIfExists('organization_setups');
    }
}
