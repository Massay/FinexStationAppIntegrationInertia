<?php

namespace App\Http\Controllers;

use App\Models\SaleTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $salesTransactions = SaleTransaction::with('user:id,email','station:id,station_id,name')->latest()->paginate(20);
        return Inertia::render('Dashboard',[
            'items' => $salesTransactions
        ]);
    }
}
