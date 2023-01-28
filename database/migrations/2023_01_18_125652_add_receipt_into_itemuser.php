<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiptIntoItemuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_user', function (Blueprint $table) {
            $table->string('payment_type')->nullable();
            $table->text('receipt')->nullable();
            $table->text('receipt_original')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_user', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('receipt');
            $table->dropColumn('receipt_original');
        });
    }
}
