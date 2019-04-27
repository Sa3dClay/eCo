<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('invoice', function(Blueprint $table) {
            $table->dropColumn('amount');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->bigInteger('phone_number');
            $table->integer('zip_code');
            $table->string('payment_m');
            $table->string('visaORacc');
          });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('invoice', function(Blueprint $table) {
              $table->integer('amount');
              $table->dropColumn('address');
              $table->dropColumn('country');
              $table->dropColumn('city');
              $table->dropColumn('phone_number');
              $table->dropColumn('zip_code');
              $table->dropColumn('payment_m');
              $table->dropColumn('visaORacc');
            });
     }
}
