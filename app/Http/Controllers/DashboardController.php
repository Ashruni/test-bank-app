<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{
    public function deposit(){
        return view('dashboard.deposits');
    }
    public function withdraw(){
        return view('dashboard.withdrawal');
    }
    public function transfer(){
        return view('dashboard.transfer');
    }
    public function statement(){
        return view('dashboard.statement');
    }


}
