<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('name')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('region')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('picture')->nullable();
            $table->string('driver_licence')->nullable();
            $table->string('vehicle_document')->nullable();
            $table->string('insurance_doc')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('approval')->nullable();
            $table->string('active')->nullable();
            $table->string('timezone')->nullable();
            $table->string('referral_id')->nullable();
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_email')->nullable();
            $table->string('guarantor_address')->nullable();
            $table->string('applied')->nullable();
            $table->string('govt_id')->nullable();
            $table->string('phone_verified')->nullable();
            $table->string('email_verified')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('sort_code')->nullable();
            $table->string('paypal_id')->nullable();
            $table->timestamps();
        });
    }
    // user_id, name, country, state, region, latitude, longitude, picture, driver_licence, vehicle_document, insurance_doc, vehicle_type, vehicle_brand, vehicle_number, approval, active, timezone, referral_id, guarantor_name, guarantor_email, guarantor_address, applied, govt_id, phone_verified, email_verified, bank_name, account_number, account_name,  sort_code, paypal_id.   [A rider will first have an account created as a user store the email, name et.c and a UUID is generated for them. That UUID will be used to link them to the rider table when storing their information during veriication and registration ].
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riders');
    }
}
