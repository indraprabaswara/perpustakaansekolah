<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeTransactions = Transaksi::where('user_id', auth()->id())
            ->whereIn('status', ['ongoing'])
            ->with(['book'])
            ->get()
            ->map(function ($transaction) {
                $transaction->borrow_date = Carbon::parse($transaction->borrow_date);
                return $transaction;
            });
    
        return view('member.dashboard', compact('activeTransactions'));
    }
}
