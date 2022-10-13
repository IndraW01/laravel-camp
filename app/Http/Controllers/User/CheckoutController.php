<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\Camp;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\Admin\PaidSuccess;
use Illuminate\Support\Facades\DB;
use App\Events\User\CheckoutSucess;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\User\CheckoutRequest;
use App\Models\Discount;
// use class midtrans
use Midtrans;

class CheckoutController extends Controller
{
    private User $user;
    private Checkout $checkout;

    public function __construct(User $user, Checkout $checkout)
    {
        $this->user = $user;
        $this->checkout = $checkout;

        //  konfigurasi Midtrans di construct
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index(Camp $camp)
    {
        if ($this->checkout->cekCheckout($camp->id)) {
            return redirect()->route('user.dashboard')->with('findCheckout', 'You have already checkout the package ' . $camp->title);
        }

        return response()->view('user.checkout.index', [
            'camp' => $camp
        ]);
    }

    public function store(CheckoutRequest $checkoutRequest, Camp $camp)
    {
        if ($this->checkout->cekCheckout($camp->id)) {
            return redirect()->route('user.dashboard')->with('findCheckout', 'You have already checkout the package ' . $camp->title);
        }

        $validateDataUser = $checkoutRequest->safe()->only(['name', 'email', 'occupation', 'phone', 'address']);

        DB::beginTransaction();
        try {
            // Update User Checkout
            $user = $this->user->userUpdate($validateDataUser);

            // konfigurasi checkout discount
            if ($checkoutRequest->discount) {
                $discount = Discount::whereCode($checkoutRequest->discount)->first();

                $dataDiscount['discount_id'] = $discount->id ?? null;
                $dataDiscount['discount_percentage'] = $discount->percentage ?? null;
            } else {
                $dataDiscount['discount_id'] =  null;
                $dataDiscount['discount_percentage'] =  null;
            }

            // Create Checkout
            $checkout = $this->checkout->checkoutCreate($camp->id, $user->id, $dataDiscount);

            // kirim kan parameter dan update table checkout
            $this->getSnapRedirect($checkout);

            DB::commit();

            // kirim email succes chekout
            CheckoutSucess::dispatch($checkout);

            return redirect()->route('checkout.success', $camp);
        } catch (Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }
    }

    public function success(Camp $camp)
    {
        return response()->view('user.checkout.success', [
            'camp' => $camp
        ]);
    }

    // konfigurasi fungsi untuk midtrans
    public function getSnapRedirect(Checkout $checkout)
    {
        // Buat Variable yang dibutuhkan
        $orderId = 'ORDER-' . $checkout->id . '-' . Str::random(5);
        $price = $checkout->camp->price * 1000;

        $checkout->midtrans_booking_code = $orderId;

        // Item detail bisa lebih dari satu
        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->camp->title} Camp"
        ];

        // cek discount
        $discountPrice = 0;
        if ($checkout->discount) {
            $discountPrice = $price * $checkout->discount_percentage / 100;
            $item_details[] = [
                'id' => $checkout->discount->code,
                'price' => -$discountPrice,
                'quantity' => 1,
                'name' => "Discount {$checkout->discount->name} ({$checkout->discount_percentage})"
            ];
        }

        // buat total
        $total = $price - $discountPrice;
        // Bikin Transaksi detailnya seperti di doc
        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $total
        ];

        // Buat Varibael untuk billing dan shipping address
        $userData = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'address' => $checkout->user->address,
            'city' => '',
            'postal_code' => '',
            'phone' => $checkout->user->phone,
            'country_code' => 'IDN'
        ];

        // Buat Costumer
        $customer_details = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'email' => $checkout->user->email,
            'phone' => $checkout->user->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData
        ];

        $midtrans_paramps = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($midtrans_paramps)->redirect_url;
            // Update Table Checkout
            $checkout->midtrans_url = $paymentUrl;
            $checkout->total = $total;
            $checkout->save();

            return $paymentUrl;
        } catch (Exception $exception) {
            return false;
        }
    }

    // Buat Callback function untuk http notification midtrans
    public function midtransCallback(Request $request)
    {
        $notif = $request->method() == 'POST' ? new Midtrans\Notification() : Midtrans\Transaction::status($request->order_id);

        $transaction_status = $notif->transaction_status;
        $farud = $notif->fraud_status;

        // get checkout id
        $checkout_id = explode('-', $notif->order_id)[1];
        $checkout = Checkout::find($checkout_id);
        // get camp
        $camp = $checkout->camp;

        // cek kondisi pembayaran
        if ($transaction_status == 'capture') {
            if ($farud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $checkout->payment_status = 'pending';
            } else if ($farud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $checkout->payment_status = 'paid';
            }
        } else if ($transaction_status == 'cancel') {
            if ($farud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            } else if ($farud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            }
        } else if ($transaction_status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status = 'failed';
        } else if ($transaction_status == 'settlement') {
            // TODO Set payment status in merchant's database to 'settlement'
            $checkout->payment_status = 'paid';
        } else if ($transaction_status == 'pending') {
            // TODO Set payment status in merchant's database to 'pending'
            $checkout->payment_status = 'pending';
        } else if ($transaction_status == 'expire') {
            // TODO Set payment status in merchant's database to 'expire'
            $checkout->payment_status = 'failed';
        }

        $checkout->save();

        return view('user.checkout.success', [
            'camp' => $camp
        ]);
    }

    // Admin
    // public function paidAbort()
    // {
    //     return abort(404);
    // }

    // public function paid(Checkout $checkout)
    // {
    //     $checkout->setToPaid();

    //     event(new PaidSuccess($checkout));

    //     Alert::success('Berhasil', 'Success Set to Paid User ' . $checkout->load('user')->user->name);

    //     return back();
    // }
}
