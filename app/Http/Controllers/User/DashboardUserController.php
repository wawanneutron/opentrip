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
        return view('pages.user.dashboard');
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
