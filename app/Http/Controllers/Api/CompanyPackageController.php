<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\CompanyPackage;
use App\Models\Package;
use App\Models\Company;
use Carbon\Carbon;
use App\Jobs\ReceivePayment;

class CompanyPackageController extends Controller
{
    public function add(Request $request)
    {
        /*validation*/
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        if ($validator->fails()) {
            $responseArr['status']  = false;
            $responseArr['message'] = $validator->errors();
            return response()->json($responseArr);
        }
        /*validation end*/

        /*what if alredy have a package?*/
        //idk
        /*what if alredy have a package? end*/

        /*calculate end_date*/
        $package = Package::whereId($request->package_id)->first();
        if($package->cycle == 'monthly'){
            $endDate = Carbon::now()->addMonth();
        } elseif ($package->cycle == 'yearly') {
            $endDate = Carbon::now()->addYear();
        }
        /*calculate end_date end*/

        /*store database*/
        $companyPackage             = new CompanyPackage;
        $companyPackage->company_id = $request->company_id;
        $companyPackage->package_id = $request->package_id;
        $companyPackage->end_at     = $endDate;
        $companyPackage->save();
        /*store database end*/

        /*return success message*/
        $responseArr['status']      = true;
        $responseArr['start_date']  = $companyPackage->created_at;
        $responseArr['end_date']    = $endDate;
        $responseArr['package']     = $package->name;
        return response()->json($responseArr);
        /*return success message end*/
    }

    public function list(Request $request)
    {
        //list from database
        $companyPackages = Company::find($request->company_id)->companyPackages()->get();

        /*return list*/
        $responseArr['status']  = true;
        $responseArr['list']    = $companyPackages;;
        return response()->json($responseArr);
        /*return list end*/
    }

    public function receivePayments()
    {
        //list companies
        $companyPackages = CompanyPackage::where('end_at', '<', Carbon::now())->get();

        //add to queue
        foreach ($companyPackages as $companyPackage) {
            ReceivePayment::dispatch($companyPackage);
        }
    }
}
