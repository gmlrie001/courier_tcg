<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDeliveryTcgPlaceIdToBasketsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn( 'baskets', 'delivery_tcg_place_id' ) ) {

            Schema::table('baskets', function (Blueprint $table) {
                $table->integer( 'delivery_tcg_place_id' )
                      ->unsigned()->nullable()
                      ->after('delivery_country');
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn( 'baskets', 'delivery_tcg_place_id' ) ) {

            Schema::table('baskets', function (Blueprint $table) {
                $table->dropColumn( 'delivery_tcg_place_id' );
            });

        }
    }

}
