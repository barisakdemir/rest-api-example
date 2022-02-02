<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Package::create([
            'id'    => 1,
            'name'  => 'Monthly Package',
            'cycle' => 'monthly',
        ]);

        \App\Models\Package::create([
            'id'    => 2,
            'name'  => 'Yearly Package',
            'cycle' => 'yearly',
        ]);
    }
}
