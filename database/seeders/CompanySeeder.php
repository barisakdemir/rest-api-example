<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<20000;$i++) {
            $name                   = Str::random(10);
            $lastName               = Str::random(10);
            $companyName            = Str::random(10);
            $companySiteExtension   = Str::random(3);
            $companySite            = Str::lower($companyName.'.'.$companySiteExtension);
            $email                  = Str::lower($name.'.'.$lastName.'@'.$companySite);

            \App\Models\Company::create([
                'status'        => 'active',
                'site_url'      => 'http://'.$companySite,
                'name'          => $name,
                'lastname'      => $lastName,
                'company_name'  => $companyName,
                'email'         => $email,
                'password'      => Hash::make(Str::random(10)),
                'token'         => Hash::make(Str::random(64)),
            ]);
        }
    }
}
