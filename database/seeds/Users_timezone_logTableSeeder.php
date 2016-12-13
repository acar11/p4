<?php

use Illuminate\Database\Seeder;

class Users_timezone_logTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users_timezone_log')->insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'user_id'    => '3',
        'zone'       => 'America/New_York',
        'user_ip'    => \Request::ip(),
      ]);
    }
}
# to run as  an individual seeeder:
# php artisan db:seed --class=Users_timezone_logTableSeeder
