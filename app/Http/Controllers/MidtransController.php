<?php

namespace App\Http\Controllers;

use App\Mail\TransactionSuccess;
use App\Transaction;
use App\TransactionDetail;
use App\TravelPackage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Midtrans\Notification;
use Midtrans\Config;
use stdClass;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // set configurasi midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cek terlebih dahulu dan cari
        $transaction = Transaction::whereKdTransaction($order_id)->first();
        $travel_package = TravelPackage::whereId($transaction->travel_packages_id)->first();
        $transactions_detail_count = TransactionDetail::whereTransactionsId($transaction->id)->count();
        $transactions_detail = TransactionDetail::whereTransactionsId($transaction->id)->get();

        // Handle notification status midtrans
        if ($status == 'settlement') {
            /* loop no tiket ke setiap teman yang ditambahkan */
            foreach ($transactions_detail as $datas) {
                $length = 6;
                $random = '';
                for ($i = 0; $i < $length; $i++) {
                    $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
                }
                $no_tiket = 'TIKET-' . Str::upper($random);
                $datas->no_ticket = $no_tiket;
                $datas->update();
            }
            $transaction->transaction_status = 'SUCCESS';
            $travel_package->quota -= $transactions_detail_count;
            $travel_package->save();
            ##gw ganteng
        } else if ($status == 'pending') {
            $transaction->transaction_status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->transaction_status = 'FAILED';
        } else if ($status == 'expire') {
            $transaction->transaction_status = 'EXPIRED';
        } else if ($status == 'cancel') {
            $transaction->transaction_status = 'FAILED';
        }
        $transaction->save();

        // kirimakan email ke masing masing member
        if ($transaction) {
            if ($status == 'capture' && $fraud == 'acept') {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            } else if ($status == 'settlement') {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            } else if ($status == 'success') {
                Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
            } else if ($status == 'capture' && $fraud == 'challenge') {

                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans payment challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans payment not sttlement'
                    ]
                ]);
            }
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans notification success'
                ]
            ]);
        }
    }

    public function finishRedirect(Request $request)
    {
        return view('pages.succses');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('pages.unfinish');
    }

    public function errorRedirect(Request $request)
    {
        return view('pages.failed');
    }
}
