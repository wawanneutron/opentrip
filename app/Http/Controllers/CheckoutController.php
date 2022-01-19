<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionSuccess;

use App\Transaction;
use App\TransactionDetail;
use App\TravelPackage;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $travel_package_id  = Transaction::with(['travel_package'])->find($id);
        $cek_member         = TransactionDetail::whereTransactionsId($id)->count();
        $cek_kuota          = $travel_package_id->travel_package->quota;

        $item = Transaction::with(['details', 'travel_package', 'user'])->findOrFail($id);
        return view('pages.checkout', [
            'item' => $item,
            'cek_kuota' => $cek_kuota,
            'cek_member' => $cek_member
        ]);
    }

    public function process(Request $request, $id)
    {
        $travel_package = TravelPackage::findOrFail($id);

        $length = 8;
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        $kdTransaction = 'TRP-' . Str::upper($random);

        $transaction = Transaction::create([
            'travel_packages_id' => $id,
            'kd_transaction' => $kdTransaction,
            'users_id' => Auth::user()->id,
            'transaction_total' => $travel_package->price,
            'transaction_status' => 'IN_CART'
        ]);

        $transactionDetail = TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'users_id' => Auth::user()->id,
        ]);

        if ($transaction || $transactionDetail) {
            return redirect()->route('checkout', $transaction->id)
                ->with(['success' => 'Checkout berhasil, anda bisa mengajak teman untuk pergi bersama, sebelum melanjutkan kepembayaran']);
        } else {
            return redirect()->route('details', $transaction->travel_package->slug)
                ->with(['error' => 'Gagal melakukan checkout']);
        }
    }

    public function remove(Request $request, $detail_id)
    {
        $item = TransactionDetail::findOrFail($detail_id);

        $transaction = Transaction::with(['details', 'travel_package'])
            ->findOrFail($item->transactions_id);

        $transaction->transaction_total -= $transaction->travel_package->price;
        $transaction->save();
        $item->delete();

        if ($item) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    public function searchFreand(Request $req, $id)
    {
        $travel_package_id  = Transaction::with(['travel_package'])->find($id);
        $cek_member         = TransactionDetail::whereTransactionsId($id)->count();
        $cek_kuota          = $travel_package_id->travel_package->quota;

        $users = User::where('userid', $req->username)
            ->orWhere('username', $req->username)
            ->get();

        $item = Transaction::with(['details', 'travel_package', 'user'])->findOrFail($id);
        return view('pages.checkout', compact('users', 'item', 'cek_kuota', 'cek_member'));
    }

    public function create(Request $request, $id)
    {
        $transaction    = Transaction::with(['travel_package'])->find($id);
        $cekDetail      = TransactionDetail::whereTransactionsId($id)->count();
        $cekMember      = TransactionDetail::whereTransactionsId($id)->whereUsersId($request->users_id);
        $cek_kuota      = $transaction->travel_package->quota;
        $cek_auth       = $request->users_id == Auth::user()->id;
        $cek_admin      = $request->users_id == User::whereId(4)->first()->id;

        if ($cek_kuota <= $cekDetail) {
            return redirect()->route('checkout', $id)
                ->with(['error' => 'Teman yang anda masukan tidak cukup dengan kuota yang ada, kuota tersisa ' . $cek_kuota]);
        } elseif ($cekMember->exists()) {
            return redirect()->route('checkout', $id)
                ->with(['error' => 'yang ditambahkan hanya bisa 1x saja dalam sekali checkout']);
        } else {
            # code...
            if ($cek_auth || $cek_admin) {
                return redirect()->route('checkout', $id)
                    ->with(['error' => 'tidak dapat menambahkan admin']);
            } else {
                $data['transactions_id'] = $id;
                $data['users_id'] = $request->users_id;
                TransactionDetail::create($data);
            }
            $transaction->transaction_total += $transaction->travel_package->price;

            $transaction->save();
        }
        if ($transaction) {
            return redirect()->route('checkout', $id)
                ->with(['success' => 'Berhasil menambahkan teman']);
        }
    }

    public function succses(Request $request, $id)
    {
        $travel_package_id  = Transaction::with(['travel_package'])->find($id);
        $cek_member         = TransactionDetail::whereTransactionsId($id)->count();
        $cek_kuota          = $travel_package_id->travel_package->quota;

        if ($cek_member > $cek_kuota) {
            return redirect()->route('checkout', $id)
                ->with(['error' => 'Teman yang anda masukan tidak cukup dengan kuota yang ada, kuota tersisa ' . $cek_kuota]);
        } elseif ($cek_kuota == 0) {
            return redirect()->route('checkout', $id)
                ->with(['error' => 'Maaf kuota sudah habis']);
        } else {
            $transaction = Transaction::with([
                'details', 'travel_package.galleries',
                'user'
            ])->findOrFail($id);
            $transaction->transaction_status = 'PENDING';

            $transaction->save();

            // Set Configurasi Midtrans
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            // Buat array untuk dikirim ke midtrans
            $midtrans_params = [
                'transaction_details' => [
                    'order_id' => $transaction->kd_transaction,
                    'gross_amount' => (int) $transaction->transaction_total
                ],
                'customer_details' => [
                    'first_name' => $transaction->user->name,
                    'email' => $transaction->user->email,
                ],
                'vtweb' => []
            ];

            try {
                //Get Snap Payment Page URL
                $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

                // Redirect to Snap Payment Page
                return redirect($paymentUrl);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
