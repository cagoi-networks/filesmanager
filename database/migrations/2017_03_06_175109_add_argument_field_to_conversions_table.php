<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArgumentFieldToConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::collection('conversions', function (Blueprint $table) {
            if (!Schema::hasColumn('conversions', 'arguments')){
                $table->string('arguments')->after('type')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_profile', function ($table) {
            if (Schema::hasColumn('conversions', 'arguments')){
                $table->dropColumn('arguments');
            }
        });
    }
}
