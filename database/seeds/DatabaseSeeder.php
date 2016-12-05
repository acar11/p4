<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        # Because `books` will be associated with `authors`,
        # authors should be seeded first
        $this->call(TasksTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
