<?php

use App\Factor;
use App\Measurer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFactorColumnToMeasurersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurers', function (Blueprint $table) {
            $table->unsignedBigInteger('factor_id')->nullable()->after('client_id');
            $table->foreign('factor_id')->references('id')->on('factors')->nullOnDelete();
        });

        $measurers = Measurer::all();

        foreach ($measurers as $medidor) {
            $factor = Factor::where('value', $medidor->correction_factor)->first();

            if ($factor) {
                $medidor->factor_id = $factor->id;
                $medidor->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurers', function (Blueprint $table) {
            $table->dropForeign(['factor_id']);
            $table->dropColumn('factor_id');
        });
    }
}
