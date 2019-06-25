<?php

use Illuminate\Database\Seeder;
use App\Models\Worker\Worker;

class WorkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::table('workers')->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM workers');
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE workers CASCADE');
        }

        factory(\App\Models\Worker\Worker::class, 10)->create();

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
