<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToMeasurersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurers', function (Blueprint $table) {
            $table->foreignId('client_id')
                ->nullable()
                ->constrained('clients');
        });
        Schema::table('clients', function (Blueprint $table){
            $table->dropForeign('clients_measurer_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurers', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}
