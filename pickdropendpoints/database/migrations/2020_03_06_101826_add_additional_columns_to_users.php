<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_verify_pin', 190)->nullable()->default(null);
            $table->string('phone_verify_status', 190)->nullable()->default(null);
            $table->string('phone_verify_date_created', 190)->nullable()->default(null);
            $table->string('email_verify_pin', 190)->nullable()->default(null);
            $table->string('email_verify_status', 190)->nullable()->default(null);
            $table->string('email_verify_date_creates', 190)->nullable()->default(null);
            $table->string('user_current_lat', 190)->nullable()->default(null);
            $table->string('user_current_lng', 190)->nullable()->default(null);
            $table->string('user_deleted', 190)->nullable()->default(null);
            $table->string('user_time_zone', 190)->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
