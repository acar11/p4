<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tasks')->insert([
       'created_at' => Carbon\Carbon::now()->toDateTimeString(),
       'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
       'title' => 'My FIRST thing to remember',
       'description' => 'Its a test to remember the FIRST thing to remember',
       'user_email' => 'f_email@gmail.com'
     ]);

     DB::table('tasks')->insert([
       'created_at' => Carbon\Carbon::now()->toDateTimeString(),
       'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
       'title' => 'My SECOND thing to remember',
       'description' => 'Its a test to remember the SECOND thing to remember',
       'user_email' => 's_email@gmail.com'
     ]);

     DB::table('tasks')->insert([
       'created_at' => Carbon\Carbon::now()->toDateTimeString(),
       'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
       'title' => 'My THIRD thing to remember',
       'description' => 'Its a test to remember the THIRD thing to remember',
       'user_email' => 't_email@gmail.com'
     ]);
    }
}
