<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return response()->view('user.dashboard', [
            'checkouts' => $this->user->userLogin()->checkouts()->with('camp')->get()
        ]);
    }
}
