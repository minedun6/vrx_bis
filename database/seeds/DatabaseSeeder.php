<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AccessTableSeeder::class);
        $this->call(GameTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(BoxStatusTableSeeder::class);
        //$this->call(BoxTableSeeder::class);
        //$this->call(WorkerTableSeeder::class);
        //$this->call(HistoricsTableSeeder::class);
        Model::reguard();
    }
}
