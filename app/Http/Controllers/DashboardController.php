<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use function Symfony\Component\String\b;

class DashboardController
{
    public function deposit()
    {
        return view('dashboard.deposits');
    }

    public function storeDeposits()
    {
        $deposit = request()->validate(
            [
                'deposits' => 'required|numeric|min:1|max:100000',
            ],
            [
                'deposits.min' => 'The deposits amount must be at least 1 rupee.',
                'deposits.max' => 'The deposits amount must not exceed 30,000,000.'
            ]
        );
        $userId = Auth()->id();
        if ($deposit) {
            Bank::create([
                'deposits' => $deposit['deposits'],
                'user_id' => $userId,
            ]);
            return redirect('/deposits')->with('success', 'Amount deposited');
        } else {
            return redirect('/deposits')->with('error', 'something went wrong');
        }
    }
    public function withdraw()
    {
        return view('dashboard.withdrawal');
    }
    public function deficitAmount()
    {
        $withdrawal = request()->validate(
            [
                'withdrawal' => 'required|numeric|min:1|max:10000000',
            ],
            [
                'withdrawal.min' => 'The deposits amount must be at least 1 rupee.',
                'withdrawal.max' => 'The deposits amount must not exceed 30,000,000.'
            ]
        );
        // $email = $withdrawal['email'];
         $email= Auth()->user()->email;
         $userId = Auth()->id;
        $deposits = DB::table('banks')->where('user_id', $userId)->sum('deposits');
        $withdraws = DB::table('banks')->where('user_id', $userId)->sum('withdrawals');
        $deficitAmount = DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers');
        $surplusAmount = DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers');
        $deposits = intval($deposits);
        $withdraws = intval($withdraws);
        $surplusAmount = intval($surplusAmount);
        $deficitAmount = intval($deficitAmount);

        $balanceBeforeTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        // DD($balanceBeforeTransaction);
        $balanceAfterTransaction = $balanceBeforeTransaction - $withdrawal['$withdrawal'];

        // $currentBalance = ($deposits - $withdraws);
        // $currentBalance = $currentBalance - $withdrawal['withdrawal'];

        if ($balanceAfterTransaction >= 0) {
            $withdraw = Bank::create(
                [
                    'withdrawals' => $withdrawal['withdrawal'],
                    'user_id' => $userId,
                ]
            );;
            // DD($currentBalance);

            return redirect('/withdraw')->with('success', 'Amount has successfully withdrawn');
        } else {
            return redirect('/withdraw')->with('error', 'Insufficient Bank balance');
        }
    }
    public function transfer()
    {
        return view('dashboard.transfer');
    }

    public function transferAmount()
    {
        $transferValidation = request()->validate(
            [

                'email' => 'required|email|exists:users,email',
                'transfers' => 'required|numeric|min:1|max:1000000',
            ],
            [
                'transfers.min' => 'The deposits amount must be at least 1 rupee.',
                'transfers.max' => 'The deposits amount must not exceed 30,000,000.',
                'email.exists'=>'This email does not exist in our records',
                'email.required' =>'This field is required'
            ]
        );
        $email = $transferValidation['email'];
        $currentEmail = $userId = Auth()->user()->email;
        $deposits = DB::table('banks')->where('user_id', $userId)->sum('deposits');
        $withdraws = DB::table('banks')->where('user_id', $userId)->sum('withdrawals');
        $deficitAmount = DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers');
        $surplusAmount = DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers');
        $deposits = intval($deposits);
        $withdraws = intval($withdraws);
        $surplusAmount = intval($surplusAmount);
        $deficitAmount = intval($deficitAmount);


        $balanceBeforeTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        // DD($balanceBeforeTransaction);
        $balanceAfterTransaction = $balanceBeforeTransaction - $transferValidation['transfers'];
        // DD( $balanceAfterTransaction);


        $userId = Auth()->id();
        if ($transferValidation && $balanceBeforeTransaction > 0) {
            if ($email != $currentEmail) {
                if ($balanceAfterTransaction >= 0) {
                    Bank::create([
                        'email' => $email,
                        'transfers' => $transferValidation['transfers'],
                        'user_id' => $userId,
                    ]);
                    $balanceAfterTransaction = $balanceBeforeTransaction - $transferValidation['transfers'];
                    return redirect('/transfer')->with('success', 'Successfully transferred');
                } else {
                    return redirect('/transfer')->with('error', 'Insufficient bank balance');
                }
            } else {
                return redirect('/transfer')->with('error', 'Enter the recipient email address');
            }
            return redirect('/transfer')->with('error', 'Something went wrong');
        }
    }
    //

    public function statement()
    {
        return view('dashboard.statement');
    }
    public function show()
    {
        $email = Auth()->user()->email;
        $userId = Auth()->id;
        $deposits = DB::table('banks')->where('user_id', $userId)->sum('deposits');
        $withdraws = DB::table('banks')->where('user_id', $userId)->sum('withdrawals');
        $deficitAmount = DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers');
        $surplusAmount = DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers');
        $deposits = intval($deposits);
        $withdraws = intval($withdraws);
        $surplusAmount = intval($surplusAmount);
        $deficitAmount = intval($deficitAmount);


        $currentTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        return view('dashboard.home')->with('totalBalances',$currentTransaction);
    }
}
