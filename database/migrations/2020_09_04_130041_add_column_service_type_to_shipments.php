<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnServiceTypeToShipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if( Schema::hasColumn('shipments', 'service_type' ) ) {
        Schema::table('shipments', function (Blueprint $table) {
          $table->dropColumn('service_type');
        });
      } else {
        Schema::table('shipments', function (Blueprint $table) {
          $table->string('service_type', 191)->nullable();
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
      if (Schema::hasColumn('shipments', 'service_type')) {
          Schema::table('shipments', function (Blueprint $table) {
              $table->dropColumn('service_type');
          });
      }
    }
}
