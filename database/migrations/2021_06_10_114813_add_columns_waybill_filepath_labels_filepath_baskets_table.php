<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsWaybillFilepathLabelsFilepathBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn( 'baskets', 'waybill_filepath' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
                $table->text( 'waybill_filepath' )->nullable()
                      ->after( 'labels_sticker' );
            });
        }
      
        if ( ! Schema::hasColumn( 'baskets', 'labels_filepath' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
                $table->text( 'labels_filepath' )->nullable()
                      ->after( 'waybill_filepath' );
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
        if ( Schema::hasColumn( 'baskets', 'waybill_filepath' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
              $table->dropColumn( 'waybill_filepath' );
            });
        }

        if ( Schema::hasColumn( 'baskets', 'labels_filepath' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
                $table->dropColumn( 'labels_filepath' );
            });
        }
    }
}
