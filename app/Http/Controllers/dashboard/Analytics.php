<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use App\Models\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing;

class Analytics extends Controller
{
  public function index()
  {
    $user = User::whereNot('usertype', User::USER_TYPE_CLIENT)->count();
    $client = Clients::count();
    $bills = Billing::with('billOwner.user')
      ->whereMonth('date_issued', now()->month)
      ->orderByDesc('date_issued')
      ->get();

    $totalPaid = $bills->where('is_paid', true)->pluck('price')->sum();
    $total = $bills->pluck('price')->sum();

    return view('content.dashboard.dashboards-analytics', compact('user', 'client', 'bills', 'totalPaid', 'total'));
  }
}
