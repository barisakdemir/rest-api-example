<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function list()
    {
        //list from database
        $packages = Package::select('id', 'name', 'cycle')->get();

        /*return list*/
        $responseArr['status']  = true;
        $responseArr['list']    = $packages;;
        return response()->json($responseArr);
        /*return list end*/
    }
}
