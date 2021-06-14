<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsWaybillStickerAndLabelsStickerBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn( 'baskets', 'waybill_sticker' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
              $table->longText( 'waybill_sticker' )->nullable();
            });
          }
      
          if ( ! Schema::hasColumn( 'baskets', 'labels_sticker' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
              $table->longText( 'labels_sticker' )->nullable()->after( 'waybill_sticker' );
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
        if ( Schema::hasColumn( 'baskets', 'waybill_sticker' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
              $table->dropColumn( 'waybill_sticker' );
            });
        }

        if ( Schema::hasColumn( 'baskets', 'labels_sticker' ) ) {
            Schema::table( 'baskets', function ( Blueprint $table ) {
                $table->dropColumn( 'labels_sticker' );
            });
        }
    }
}
