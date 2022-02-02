<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Package;
use App\Models\CompanyPackage;
use App\Models\CompanyPayment;

class ReceivePayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo '>hi'.$this->data->end_at."\n";

        /*credit card proccess*/
        if(rand(1,2) == 1){
            //payment success

            /*calculate end_date*/
            $package = Package::whereId($this->data->package_id)->first();
            if($package->cycle == 'monthly'){
                $endDate = Carbon::now()->addMonth();
            } elseif ($package->cycle == 'yearly') {
                $endDate = Carbon::now()->addYear();
            }
            /*calculate end_date end*/

            /*package store database*/
            $companyPackage         = CompanyPackage::where('company_id', $this->data->company_id)->first();
            $companyPackage->end_at = $endDate;
            $companyPackage->save();
            /*package store database end*/

            //log store
            $this->paymentLog($this->data->company_id, $this->data->package_id, 'success');
        } else {
            //payment fail

            //log store
            $this->paymentLog($this->data->company_id, $this->data->package_id, 'fail');

            //check payment try count
            $paymentTry = CompanyPayment::where('company_id', $this->data->company_id)
                                        ->where('created_at', '>', Carbon::now()->subDays(3))->count();

            /*if try count == 3 company set disable*/
            if($paymentTry == 3){
                //company set disable
                $company = Company::find($this->data->company_id);
                $company->status = 'passive';
                $company->save();
            } else {
                //continue try
                ReceivePayment::dispatch($this->data)->delay(Carbon::now()->addDay());
            }
            /*if try count == 3 company set disable end*/
        }
        /*credit card proccess end*/

        sleep(1);
    }

    protected function paymentLog($company_id, $package_id, $result)
    {
        /*package store database*/
        $companyPayment             = new CompanyPayment;
        $companyPayment->company_id = $company_id;
        $companyPayment->package_id = $package_id;
        $companyPayment->result     = $result;
        $companyPayment->save();
        /*package store database end*/
    }
}
