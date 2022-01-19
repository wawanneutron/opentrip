<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        return view('pages.user.dashboard', [
            'transactions' => Transaction::whereUsersId(Auth::user()->id)->count(),
            'transaction_pending' => Transaction::whereTransactionStatus('PENDING')->whereUsersId(Auth::user()->id)->count(),
            'transaction_success' => Transaction::whereTransactionStatus('SUCCESS')->whereUsersId(Auth::user()->id)->count(),
            'transaction_cart' => Transaction::whereTransactionStatus('IN_CART')->whereUsersId(Auth::user()->id)->count(),
        ]);
    }

    public function historyTransaction()
    {
        $historytTransaction = Transaction::latest()
            ->whereUsersId(Auth::user()->id)
            ->get();
        return view('pages.user.transaction.index', [
            'histories' => $historytTransaction
        ]);
    }

    public function detailTransaction($id)
    {
        $detailTransaction = Transaction::with('details')->findOrFail($id);
        return view('pages.user.transaction.detail', [
            'item' => $detailTransaction
        ]);
    }

    public function destroy($id)
    {
        $item = Transaction::findOrFail($id);
        $item->delete();

        if ($item) {
            return response()->json([
                'status'    => 'success',
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
            ]);
        }
    }
}
