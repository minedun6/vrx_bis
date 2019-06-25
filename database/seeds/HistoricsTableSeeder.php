<?php

use Illuminate\Database\Seeder;

class HistoricsTableSeeder extends Seeder
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
            DB::table('historics')->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM historics');
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE historics CASCADE');
        }

        factory(\App\Models\Game\GameHistoric::class, 10000)->create();

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
