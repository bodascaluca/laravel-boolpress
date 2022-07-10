<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PostTablesSeeder::class);
         $this->call(CategoriesTableSeed::class);
         $this->call(TagSeeder::class);
    }
}
