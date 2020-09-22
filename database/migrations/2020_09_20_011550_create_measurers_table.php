<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('model');
            $table->string('serial_number')->unique();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurers');
    }
}
