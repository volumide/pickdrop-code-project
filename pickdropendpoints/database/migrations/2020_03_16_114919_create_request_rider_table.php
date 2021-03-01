<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRiderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_rider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_uuid');
            $table->string('rider_uuid');
            $table->string('pick_up_location');
            $table->string('drop_up_location');
            $table->string('pick_up_date');
            $table->string('pick_up_time');
            $table->text('pick_up_instruction')->nullable();
            $table->string('vehicle');
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('request_rider');
    }
}
