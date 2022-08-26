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
            $table->double('correction_factor');
            $table->string('period');
            $table->integer('adm_charge');
            $table->integer('subtotal');
            $table->integer('iva');
            $table->double('price');
            $table->integer('total');
            $table->integer('pending');
            $table->integer('previous_balance');
            $table->bigInteger('reference')->default(0);
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
