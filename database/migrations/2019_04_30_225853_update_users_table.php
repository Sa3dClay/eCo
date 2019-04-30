<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function(Blueprint $table) {
          $table->string('address')->nullable(true);
          $table->string('country')->nullable(true);
          $table->string('city')->nullable(true);
          $table->bigInteger('phone_number')->nullable(true);
          $table->integer('zip_code')->nullable(true);
          $table->string('payment_m')->nullable(true);
          $table->string('visaORacc')->nullable(true);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function(Blueprint $table) {
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
