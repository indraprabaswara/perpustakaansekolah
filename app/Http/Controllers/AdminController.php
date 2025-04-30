<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    $availableVehicles = Book::where('status', 'available')->count();
    $totalTransactions = Transaksi::count();
    $registeredUsers = User::where('role', '!=', 'admin')->count();


    return view('admin.dashboard', compact(
        'availableVehicles',
        'totalTransactions',
        'registeredUsers',
    ));
}
}
