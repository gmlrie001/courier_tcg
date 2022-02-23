<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThecourierguyShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable( 'thecourierguy_shippings' ) ) {
            Schema::create('thecourierguy_shippings', function (Blueprint $table) {
                $table->bigIncrements('id');
    
                $table->boolean('enabled')->default(0)->nullable();
    
                $table->string('account_number')->nullable();
                $table->string('account_pin')->nullable();
                $table->string('account_serivice')->nullable();
    
                $table->string('origin_street_address')->nullable();
                $table->string('origin_business_park')->nullable();
                $table->string('origin_other_address')->nullable();
                $table->string('origin_suburb')->nullable();
                $table->string('origin_town')->nullable();
                $table->string('origin_place_id')->unique();
                $table->string('origin_province_state')->nullable();
                $table->string('origin_country_code')->nullable();
                $table->string('origin_country_name')->nullable();
                $table->string('origin_postal_code')->nullable();
    
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
        if (Schema::hasTable('thecourierguy_shippings')) {
            Schema::dropIfExists('thecourierguy_shippings');
        }
    }
}
