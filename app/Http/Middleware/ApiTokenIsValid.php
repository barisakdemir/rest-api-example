<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Company;

class ApiTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isTokenInvalid = false;

        /*check token is valid?*/
        $company = Company::where('token', $request->_token)->first();

        if (!$company) {
            $isTokenInvalid = true;
        }
        /*check token is valid? end*/

        /*compare token and company_id if exist*/
        if(isset($request->company_id) and $isTokenInvalid == false) {
            if ($company->id != $request->company_id) {
                $isTokenInvalid = true;
            }
        }
        /*compare token and company_id if exist end*/

        //add company id to request
        if($company and $isTokenInvalid == false) {
            $request->mergeIfMissing(['company_id' => $company->id]);
        }

        /*return error message*/
        if($isTokenInvalid == true) {
            $responseArr['status']  = false;
            $responseArr['message'] = 'Invalid Token!';
            return response()->json($responseArr);
        }
        /*return error message end*/

        return $next($request);
    }
}
