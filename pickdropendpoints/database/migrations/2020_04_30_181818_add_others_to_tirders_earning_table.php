<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOthersToTirdersEarningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riders_earning', function (Blueprint $table) {
            $table->string('customer_uuid')->nullable();
            $table->string('rider_uuid')->nullable();
            $table->string('request_uuid')->nullable();
            $table->string('price')->nullable();
            $table->string('payment_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tirders_earning', function (Blueprint $table) {
            //
        });
    }
}
