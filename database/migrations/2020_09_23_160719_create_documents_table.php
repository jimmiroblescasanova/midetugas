<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->dateTime('date');
            $table->dateTime('payment_date');
            $table->double('final_quantity');
            $table->double('start_quantity');
            $table->double('month_quantity');
            $table->string('period');
            $table->double('total');
            $table->double('pending');
            $table->string('payment_method')->nullable();
            $table->string('invoice')->nullable();
            $table->integer('status')->default(1);
            $table->string('photo');
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('documents');
    }
}
