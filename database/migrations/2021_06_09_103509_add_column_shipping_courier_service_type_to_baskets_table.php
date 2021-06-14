<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShippingCourierServiceTypeToBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if ( ! Schema::hasColumn( 'baskets', 'shipping_courier_service_type' ) ) {

        Schema::table( 'baskets', function ( Blueprint $table ) {
          $table->string( 'shipping_courier_service_type' )
                ->nullable()
                ->after( 'shipping_title' );
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
      if ( Schema::hasColumn( 'baskets', 'shipping_courier_service_type' ) ) {

        Schema::table( 'baskets', function ( Blueprint $table ) {
          $table->dropColumn( 'shipping_courier_service_type' );
        });

      }
    }
}
