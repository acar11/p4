<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTimezoneLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_timezone_log', function (Blueprint $table) {

          # Increments method will make a Primary, Auto-Incrementing field.
          $table->increments('id');

          # This generates two columns: `created_at` and `updated_at` to
          # keep track of changes to a row
          $table->timestamps();

          # The rest of the fields...
          $table->string('zone')->nullable();
          $table->string('user_ip')->nullable();

          # `user_id` that has to be unsigned (i.e. positive)
          $table->integer('user_id')->unsigned();

          # This field `user_id` is a foreign key that connects
          # to the `user_id` field in the `tasks` table
          $table->foreign('user_id')->references('user_id')->on('tasks');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_timezone_log');
    }
}
