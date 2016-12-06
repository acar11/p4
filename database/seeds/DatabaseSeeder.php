<?php

#use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

#use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        #$this->call(UsersTableSeeder::class);

    }
}
