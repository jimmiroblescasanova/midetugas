<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('name');
            $table->string('shortName');
            $table->string('rfc')->unique();
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('phone');
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('line_3')->nullable();
            $table->string('locality')->nullable();
            $table->string('city')->nullable();
            $table->string('state_province')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('ref1_name')->nullable();
            $table->string('ref1_phone')->nullable();
            $table->string('ref2_name')->nullable();
            $table->string('ref2_phone')->nullable();
            $table->integer('balance')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('reconnection_charge')->default(0);
            $table->integer('deposit')->default(0);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->timestamps();
        });

        DB::update("ALTER TABLE clients AUTO_INCREMENT = 5000;");
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
