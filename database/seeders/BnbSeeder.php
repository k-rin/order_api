<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BnbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bnbs')->insert([
            'id'       => 456,
            'name'     => 'name',
            'city'     => 'city',
            'district' => 'district',
            'street'   => 'street',
        ]);
    }
}
