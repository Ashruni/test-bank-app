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

        $email = Auth()->user()->email;
        $userId = Auth()->user()->id;
        $deposits = intval(DB::table('banks')->where('user_id', $userId)->sum('deposits'));
        $withdraws = intval(DB::table('banks')->where('user_id', $userId)->sum('withdrawals'));
        $deficitAmount = intval(DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers'));
        $surplusAmount = intval(DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers'));

        $balanceBeforeTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        $balanceAfterTransaction = $balanceBeforeTransaction - $withdrawal['withdrawal'];
        if ($balanceAfterTransaction >= 0) {
            $withdraw = Bank::create(
                [
                    'withdrawals' => $withdrawal['withdrawal'],
                    'user_id' => $userId,
                ]
            );;


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
                'email.exists' => 'This email does not exist in our records',
                'email.required' => 'This field is required'
            ]
        );
        $email = $transferValidation['email'];
        $userId = Auth()->user()->id;
        $currentEmail = Auth()->user()->email;
        $deposits = intval(DB::table('banks')->where('user_id', $userId)->sum('deposits'));
        $withdraws = intval(DB::table('banks')->where('user_id', $userId)->sum('withdrawals'));
        $deficitAmount = intval(DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers'));
        $surplusAmount = intval(DB::table('banks')->where('email', $currentEmail)->whereNotNull('transfers')->sum('transfers'));

        $balanceBeforeTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        $balanceAfterTransaction = $balanceBeforeTransaction - $transferValidation['transfers'];


        $userId = Auth()->user()->id;
        $currentEmail = Auth()->user()->email;
        if ($transferValidation['transfers'] <= $balanceBeforeTransaction) {
            if ($email != $currentEmail) {
                if ($balanceAfterTransaction >= 0) {
                    $balanceAfterTransaction = $balanceBeforeTransaction - $transferValidation['transfers'];
                    Bank::create([
                        'email' => $email,
                        'transfers' => $transferValidation['transfers'],
                        'user_id' => $userId,
                    ]);

                    // DD($balanceAfterTransaction);
                    return redirect('/transfer')->with('success', 'Successfully transferred');
                } else {
                    return redirect('/transfer')->with('error', 'Enter the recipient address');
                }
            }
        } else {
            return redirect('/transfer')->with('error', 'Insufficient Bank Balance ');
        }
    }


    public function statement()
    {

        $userId = Auth()->user()->id;
        $email = Auth()->user()->email;
        $userId = Auth()->user()->id;
        $deposits = intval(DB::table('banks')->where('user_id', $userId)->sum('deposits'));
        $withdraws = intval(DB::table('banks')->where('user_id', $userId)->sum('withdrawals'));
        $deficitAmount = intval(DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers'));
        $surplusAmount = intval(DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers'));
        $currentTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);

        return view('dashboard.statement', ['details' => Bank::where('user_id', $userId)->simplePaginate(5)])->with('currentTransactions', $currentTransaction);
    }
    public function show()
    {
        $email = Auth()->user()->email;
        $userId = Auth()->user()->id;
        $deposits = intval(DB::table('banks')->where('user_id', $userId)->sum('deposits'));
        $withdraws = intval(DB::table('banks')->where('user_id', $userId)->sum('withdrawals'));
        $deficitAmount = intval(DB::table('banks')->where('user_id', $userId)->whereNotNull('transfers')->whereNotNull('email')->sum('transfers'));
        $surplusAmount = intval(DB::table('banks')->where('email', $email)->whereNotNull('transfers')->sum('transfers'));

        $currentTransaction  = ($deposits + $surplusAmount) - ($withdraws + $deficitAmount);
        // DD($currentTransaction);
        return view('dashboard.home')->with('totalBalances', $currentTransaction);
    }
}
