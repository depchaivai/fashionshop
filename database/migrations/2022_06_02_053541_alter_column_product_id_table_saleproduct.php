<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnProductIdTableSaleproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saleproduct', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('product_interface');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saleproduct', function (Blueprint $table) {
            $table->dropForeign('product_id');
        });
    }
}
