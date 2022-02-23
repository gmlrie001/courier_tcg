<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShippingDocsToBasketShipmentCourierTcgTrackersTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if ( ! Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'waybill_blob' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->longText( 'waybill_blob' )->nullable()->after( 'tcg_collect_number' );
      });
    }

    if ( ! Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'waybill_path' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->text( 'waybill_path' )->nullable()->after( 'waybill_blob' );
      });
    }

    if ( ! Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'labels_blob' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->longText( 'labels_blob' )->nullable()->after( 'waybill_path' );
      });
    }

    if ( ! Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'labels_path' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->text( 'labels_path' )->nullable()->after( 'labels_blob' );
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
    if ( Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'waybill_blob' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->dropColumn( 'waybill_blob' );
      });
    }

    if ( Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'waybill_path' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->dropColumn( 'waybill_path' );
      });
    }

    if ( Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'labels_blob' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->dropColumn( 'labels_blob' );
      });
    }
    
    if ( Schema::hasColumn( 'basket_shipment_courier_tcg_trackers', 'labels_path' ) ) {
      Schema::table( 'basket_shipment_courier_tcg_trackers', function ( Blueprint $table ) {
        $table->dropColumn( 'labels_path' );
      });
    }
  }

}
