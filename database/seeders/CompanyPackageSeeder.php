<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Nette\Utils\Random;

class CompanyPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //list all company
        $companies = \App\Models\Company::get();

        /*add a package for all companies*/
        foreach ($companies as $company) {
            ;

            /*store database*/
            $companyPackage             = new \App\Models\CompanyPackage;
            $companyPackage->company_id = $company->id;
            $companyPackage->package_id = rand(1,2);
            $companyPackage->end_at     = Carbon::now()->subMonth();
            $companyPackage->save();
            /*store database end*/
        }
        /*add a package for all companies end*/
    }
}
