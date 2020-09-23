<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('name');
            $table->string('rfc')->unique();
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('phone');
            $table->string('ref1_name')->nullable();
            $table->string('ref1_phone')->nullable();
            $table->string('ref2_name')->nullable();
            $table->string('ref2_phone')->nullable();
            $table->unsignedBigInteger('measurer_id')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
