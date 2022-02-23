<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketShipmentCourierTcgTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('basket_shipment_courier_tcg_trackers')) {
            Schema::create('basket_shipment_courier_tcg_trackers', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->bigInteger('basket_id')->default(0)->unsigned()->index();
                $table->boolean('enabled')->default(0)->unsigned();

                $table->string('delivery_tcg_place')->nullable();
                $table->bigInteger('delivery_tcg_place_id')->default(0)->unsigned();

                $table->string('tcg_quote_number')->nullable();
                $table->string('tcg_waybill_number')->nullable();
                $table->string('tcg_collect_number')->nullable();

                $table->longText('all_services')->nullable();

                $table->string('selected_service')->nullable();
                $table->string('service')->nullable();
                $table->string('service_rate')->nullable();

                $table->bigInteger('thecourierguy_shipping_id')->unsigned();

                $table->timestamps();
                $table->softDeletes();

                $table->enum('status', array('PUBLISHED','UNPUBLISHED','DRAFT','SCHEDULED'))->nullable()->default('PUBLISHED');
                $table->dateTime('status_date')->nullable();

                $table->integer('order')->default(1)->nullable();
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
        if (Schema::hasTable('basket_shipment_courier_tcg_trackers')) {
            Schema::dropIfExists('basket_shipment_courier_tcg_trackers');
        }
    }
}
