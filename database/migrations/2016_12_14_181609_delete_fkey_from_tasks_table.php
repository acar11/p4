<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFkeyFromTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users_timezone_log', function($table)
      {
        $table->dropForeign('users_timezone_log_user_id_foreign');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users_timezone_log', function (Blueprint $table) {
        $table->foreign('user_id')->references('user_id')->on('tasks');
      });
    }
}
