<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAramexShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn( 'aramex_shippings', 'account_number' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->text( 'account_number' )->nullable()
                      ->after( 'password' );
            });
        }

        if ( ! Schema::hasColumn( 'aramex_shippings', 'account_pin' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->text( 'account_pin' )->nullable()
                      ->after( 'account_number' );
            });
        }

        if ( ! Schema::hasColumn( 'aramex_shippings', 'origin_towncity' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->text( 'origin_towncity' )->nullable()
                      ->after( 'account_pin' );
            });
        }

        if ( ! Schema::hasColumn( 'aramex_shippings', 'parcel_document' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->text( 'parcel_document' )->nullable()
                      ->after( 'origin_towncity' );
            });
        }

        if ( ! Schema::hasColumn( 'aramex_shippings', 'account_service_type' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->text( 'account_service_type' )->nullable()
                      ->after( 'parcel_document' );
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
        if ( Schema::hasColumn( 'aramex_shippings', 'account_number' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->dropColumn( 'account_number' );
            });
        }

        if ( Schema::hasColumn( 'aramex_shippings', 'account_pin' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->dropColumn( 'account_pin' );
            });
        }

        if ( Schema::hasColumn( 'aramex_shippings', 'origin_towncity' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->dropColumn( 'origin_towncity' );
            });
        }

        if ( Schema::hasColumn( 'aramex_shippings', 'parcel_document' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->dropColumn( 'parcel_document' );
            });
        }

        if ( Schema::hasColumn( 'aramex_shippings', 'account_service_type' ) ) {
            Schema::table( 'aramex_shippings', function ( Blueprint $table ) {
                $table->dropColumn( 'account_service_type' );
            });
        }
    }
}
