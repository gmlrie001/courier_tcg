<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketTrackShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable( 'basket_track_shipments' ) ) {
            Schema::create('basket_track_shipments', function (Blueprint $table) {
                $table->bigIncrements('id');
    
                $table->string('title')->nullable();;
                $table->dateTime('estimated_delivery')->nullable();
                $table->text('tracking_number')->nullable();
    
                $table->integer('user_id')->nullable();
                $table->integer('basket_id')->nullable();
    
                $table->timestamps();
                $table->softDeletes();
    
                $table->enum('status', ['PUBLISHED', 'UNPUBLISHED', 'DRAFT', 'SCHEDULED'])->default('PUBLISHED')->nullable();
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
        if (Schema::hasTable('basket_track_shipments')) {
            Schema::dropIfExists('basket_track_shipments');
        }
    }
}
