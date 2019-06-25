<?php

use App\Models\Box\BoxStatus;
use App\Models\Box\Status;
use Illuminate\Database\Seeder;

class BoxStatusTableSeeder extends Seeder
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
            DB::table('statuses')->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM statuses');
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE statuses CASCADE');
        }

        Status::create([
            'label' => 'En Activité',
        ]);

        Status::create([
            'label' => 'Indisponible',
        ]);

        Status::create([
            'label' => 'En panne',
        ]);

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
