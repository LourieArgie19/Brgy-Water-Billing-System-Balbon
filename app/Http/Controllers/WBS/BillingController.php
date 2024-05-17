<?php

namespace App\Http\Controllers\WBS;

use App\Models\Clients; // Adjusted the import to match the model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing;

class BillingController extends Controller
{
  // Your existing methods...

  /**
   * Fetch clients' id, name, and meter number.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    return view('WBS_content.billing');
  }

  public function store(Request $request)
  {
    $prevBill = Billing::whereHas('billOwner', fn ($query) => $query->where('id', $request->client_id))->latest()->first();
    $price = ($request->current_reading - $prevBill->current_reading) * env('WATER_RATE');
    Billing::create([
      'client_id' => $request->client_id,
      'previous_reading' => $prevBill->current_reading,
      'current_reading' => $request->current_reading,
      'price' => $price,
      'date_issued' => $request->date_issued,
      'is_paid' => $price == 0 ? true : false
    ]);

    return response()->json(['success' => 'true', 'message' => 'Successfully created a new Billing']);
  }

  public function fetchBilling()
  {
    $billings = Billing::with('billOwner.user')->orderByDesc('date_issued')->get(); // Adjusted the attributes to match the model

    return response()->json(['billings' => $billings]); // Corrected key to match AJAX response
  }

  public function fetchLatest(Request $request)
  {
    $bill = Billing::whereHas('billOwner', fn ($query) => $query->where('id', $request->id))->latest()->first();

    return response()->json(['bill' => $bill]);
  }

  public function markAsPaid($id)
  {
    $bill = Billing::findOrFail($id);
    $bill->update(['is_paid' => true]);
    return back();
  }
}
