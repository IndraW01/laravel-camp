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

        $validateData = $checkoutRequest->validated();
        $validateDataUser = $checkoutRequest->safe()->only(['name', 'email', 'occupation']);

        DB::beginTransaction();
        try {
            $user = $this->user->userUpdate($validateDataUser);
            $checkout = $this->checkout->checkoutCreate($camp->id, $user->id, $validateData);

            $this->getSnapRedirect($checkout);

            DB::commit();

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

        // Bikin Transaksi detailnya seperti di doc
        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $price
        ];

        // Item detail bisa lebih dari satu
        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->camp->title} Camp"
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
            $checkout->save();

            return $paymentUrl;
        } catch (Exception $exception) {
            return false;
        }
    }

    // Admin
    public function paidAbort()
    {
        return abort(404);
    }

    public function paid(Checkout $checkout)
    {
        $checkout->setToPaid();

        event(new PaidSuccess($checkout));

        Alert::success('Berhasil', 'Success Set to Paid User ' . $checkout->load('user')->user->name);

        return back();
    }
}
