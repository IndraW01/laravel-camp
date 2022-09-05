<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private Camp $camp;

    public function __construct(Camp $camp)
    {
        $this->camp = $camp;
    }

    public function index()
    {
        return response()->view('main.dashboard', [
            'camps' =>  $this->camp->getCamps()
        ]);
    }
}
