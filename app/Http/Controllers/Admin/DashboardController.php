<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TravelPackage;
use App\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.dashboard', [
            'travel_package' => TravelPackage::count(),
            'transactions' => Transaction::count(),
            'transaction_pending' => Transaction::whereTransactionStatus('PENDING')->count(),
            'transaction_success' => Transaction::whereTransactionStatus('SUCCESS')->count(),
            'transaction_cart' => Transaction::whereTransactionStatus('IN_CART')->count(),
        ]);
    }
}
