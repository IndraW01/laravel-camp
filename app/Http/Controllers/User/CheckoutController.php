<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\Camp;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\User\CheckoutSucess;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckoutRequest;

class CheckoutController extends Controller
{
    private User $user;
    private Checkout $checkout;

    public function __construct(User $user, Checkout $checkout)
    {
        $this->user = $user;
        $this->checkout = $checkout;
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

        DB::beginTransaction();
        try {
            $user = $this->user->userUpdate($validateData);
            $checkout = $this->checkout->checkoutCreate($camp->id, $user->id, $validateData);

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
}
