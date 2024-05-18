<?php

namespace App\Http\Controllers\WBS;

use App\Models\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;
use App\Models\User;

class ClientController extends Controller
{
  /**
   * Display a listing of the clients.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    return view('WBS_content.client');
  }

  /**
   * Store a newly created client in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function saveData(Request $request)
  {
    // Validate the incoming request data
    $request->validate([
      'fullname' => 'required',
      'email' => 'required|email|unique:users,email',
      'date' => 'required|date',
      'purok' => 'required',
      'metersnumber' => 'required',
      'password' => 'required|min:8',
    ]);

    // Create a new client
    $user = User::create([
      'name' => $request->fullname,
      'email' => $request->email,
      'email_verified_at' => now(),
      'password' => bcrypt($request->password),
      'usertype' => User::USER_TYPE_CLIENT
    ]);

    Clients::create([
      'user_id' => $user->id,
      'date' => $request->date,
      'purok' => $request->purok,
      'meter_number' => $request->metersnumber,
    ]);

    // Send email
    Mail::to($user->email)->send(new SampleMail($user->name));

    return response()->json(['success' => true, 'message' => 'Client created successfully.']);
  }

  public function fetchClient()
  {
    $clients = Clients::with('user')->get();
    return response()->json([
      'client' => $clients,
    ]);
  }

  public function getClient($id)
  {
    $user = Clients::with('user')->find($id);

    if ($user) {
      return response()->json([
        'status' => 200,
        'user' => $user,
      ]);
    } else {
      return response()->json([
        'status' => 404,
        'user' => 'User Not Found',
      ]);
    }
  }

  public function updateClient(Request $request, $id)
  {
    $request->validate([
      'fullname' => 'required',
      'email' => 'required|email',
      'purok' => 'required',
      'metersnumber' => 'required',
    ]);

    // Find the user by ID
    $client = Clients::findOrFail($id);
    // Update the user's information
    $client->update([
      'purok' => $request->purok,
      'meter_number' => $request->metersnumber
    ]);

    $client->user->update([
      'name' => $request->fullname,
      'email' => $request->email
    ]);

    // Return success response
    return response()->json(['success' => true, 'message' => 'User updated successfully']);
  }

  public function destroyClient($id)
  {
    Clients::where('id', $id)->delete();

    return response()->json(['success' => true, 'message' => 'User deleted successfully']);
  }
}
