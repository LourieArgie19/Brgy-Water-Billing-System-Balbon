<?php

namespace App\Http\Controllers\WBS;

use App\Models\Clients; // Adjusted the import to match the model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

  public function fetchBilling()
  {
    $clients = Clients::select('id', 'fullname', 'metersnumber')->get(); // Adjusted the attributes to match the model

    return response()->json(['billings' => $clients]); // Corrected key to match AJAX response
  }
}
