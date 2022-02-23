<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipmentTrackIdBaskets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('baskets', 'basket_track_shipment_id')) {
            Schema::table('baskets', function (Blueprint $table) {
                $table->unsignedBigInteger('basket_track_shipment_id')->nullable();
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
        if (Schema::hasColumn('baskets', 'basket_track_shipment_id')) {
            Schema::table('baskets', function (Blueprint $table) {
                $table->dropColumn('basket_track_shipment_id');
            });
        }
    }
}
