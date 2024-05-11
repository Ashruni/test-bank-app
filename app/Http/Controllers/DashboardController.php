<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class DashboardController
{
    public function deposit(){
        return view('dashboard.deposits');
    }

    public function storeDeposits(){
        $deposit = request()->validate(
            [
                'deposits'=>'required|numeric|min:1|max:100000',

            ]);
            $userId=Auth()->id();
            if($deposit){
                 Bank::create([
                    'deposits'=>$deposit['deposits'],
                    'user_id'=>$userId,
                 ]);
                 return redirect('/deposits')->with('success','Amount deposited');
            }
            else{
                return redirect('/deposits')->with('error','something went wrong');
            }
    }
    public function withdraw(){
        return view('dashboard.withdrawal');
    }
    public function deficit(){
        
    }
    public function transfer(){
        return view('dashboard.transfer');
    }
    public function statement(){
        return view('dashboard.statement');
    }
    public function show(){
        return view('dashboard.home');
    }


}
