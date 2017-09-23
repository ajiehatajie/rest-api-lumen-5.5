<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('versions')->insert([
            'version' => '0.1.a',
            'desc' => 'penambahan pop up result not found',
            'created_at' => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('versions')->insert([
            'version' => '0.1.b',
            'desc' => 'penambahan check version apps',
            'created_at' => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        
    }
}
