<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    private Checkout $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

    public function index()
    {
        return response()->view('admin.dashboard', [
            'checkouts' => $this->checkout->getCheckouts()
        ]);
    }
}
