<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * New Table for tracking shipments and collection pickups requires:
     * waybill_tracking,
     * price, 
     * expected_delivery_date, 
     * shipping_label_link, 
     * collection_reference, 
     * basket_id and user_id.
     * 
     * POST-PROCESSING:
     * Send shipping and tracking information to customer.
     * Send shipping, tracking, shipping label and collection pickup information to client.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable( 'shipments' ) ) {
            Schema::create('shipments', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('shipper', 191)->nullable();

                $table->decimal('shipping_cost', 10, 2)->nullable();
                $table->string('estimated_delivery_date', 191)->nullable();

                $table->string('collection_pickup_number')->nullable();
                $table->string('waybill_tracking_number')->nullable();
                $table->text('shipping_label_link')->nullable();

                $table->longText('shipment_updates')->nullable();

                $table->bigInteger('basket_id')->unsigned()->nullable();
                $table->bigInteger('user_id')->unsigned()->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->enum('status', array('PUBLISHED','UNPUBLISHED','DRAFT','SCHEDULED'))->nullable()->default('PUBLISHED');
                $table->dateTime('status_date')->nullable();

                $table->integer('order')->default(1);
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
        if (Schema::hasTable('shipments')) {
            Schema::dropIfExists('shipments');
        }
    }
}
