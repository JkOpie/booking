<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceIntoItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
        });

        Schema::table('item_user', function (Blueprint $table) {
            $table->string('total_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });

        Schema::table('item_user', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
}
