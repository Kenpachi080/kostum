<?php

namespace App\Http\Controllers;

use App\Imports\UploadUsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function uploadUsers(Request $request)
    {
        Excel::import(new UploadUsersImport(), request()->file('file'));
        return 'ok';
    }
}
