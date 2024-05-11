<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

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
    public function deficitAmount(){
        $withdrawal=request()->validate([
            'withdrawal'=>'required|numeric|min:1|max:10000000',
        ]);
        $userId = Auth()->Id();
        $deposits = DB::table('banks')->where('user_id',$userId)->sum('deposits');
        $withdraws = DB::table('banks')->where('user_id',$userId)->sum('withdrawals');

        $deposits = intval($deposits);
        $withdraws= intval($withdraws);
        // $currentBalance = ($deposits - $withdraws);



            $currentBalance = ($deposits - $withdraws);
            $currentBalance = $currentBalance - $withdrawal['withdrawal'];

            if($currentBalance>=0){
                $withdraw = Bank::create(
                    [
                        'withdrawals'=>$withdrawal['withdrawal'],
                        'user_id'=>$userId,
                    ]);

                ;
                // DD($currentBalance);

                return redirect('/withdraw')->with('success','Amount has successfully withdrawn');
            }
            else{
                return redirect('/withdraw')->with('error','Insufficient Bank balance');

            }



    }
    public function transfer(){
        return view('dashboard.transfer');
    }
    public function statement(){
        return view('dashboard.statement');
    }
    public function show(){
        $userId=Auth()->id();
        $deposits = DB::table('banks')->where('user_id',$userId)->sum('deposits');
        $withdraws = DB::table('banks')->where('user_id',$userId)->sum('withdrawals');
        $deposits=intval($deposits);
        $withdraw=intval($withdraws);
        $totalBalances =($deposits-$withdraw);
        return view('dashboard.home')->with('totalBalances',$totalBalances);
    }


}
