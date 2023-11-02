<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboardData(){
        $employees = Employee::count();
        $companies = Company::count();
        return response()->json([
            'employees' => $employees,
            'companies' => $companies,
        ]);
    }
}
