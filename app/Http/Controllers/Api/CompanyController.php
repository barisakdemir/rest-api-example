<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanyController extends Controller
{
    public function register(Request $request)
    {
        /*validation*/
        $validator = Validator::make($request->all(), [
            'site_url'      => 'required|url',
            'name'          => 'required',
            'lastname'      => 'required',
            'company_name'  => 'required',
            'email'         => 'required|email|unique:companies',
            'password'      => ['required', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            $responseArr['status']  = false;
            $responseArr['message'] = $validator->errors();
            return response()->json($responseArr);
        }
        /*validation end*/

        /*generate hash*/
        $tokenHash = Hash::make(Str::random(64));

        /*store database*/
        $company                = new Company;
        $company->status        = 'active';
        $company->site_url      = $request->site_url;
        $company->name          = $request->name;
        $company->lastname      = $request->lastname;
        $company->company_name  = $request->company_name;
        $company->email         = $request->email;
        $company->password      = Hash::make($request->password);
        $company->token         = $tokenHash;
        $company->save();
        /*store database end */

        /*return success message*/
        $responseArr['status']      = true;
        $responseArr['token']       = $tokenHash;
        $responseArr['company_id']  = $company->id;
        return response()->json($responseArr);
        /*return success message end*/
    }

    public function list()
    {
        //list from database
        $company = Company::find(session('company_id'), ['id', 'status', 'site_url', 'name', 'lastname', 'company_name', 'email', 'created_at']);

        /*return list*/
        $responseArr['status']  = true;
        $responseArr['list']    = $company;;
        return response()->json($responseArr);
        /*return list end*/
    }
}
