<?php

namespace App\Http\Controllers\WBS;

use App\Models\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;

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
    $data = $request->validate([
      'fullname' => 'required',
      'email' => 'required|email|unique:client,email',
      'date' => 'required|date',
      'purok' => 'required',
      'metersnumber' => 'required',
      'password' => 'required|min:5|max:8',
    ]);

    // Hash the password
    $data['password'] = bcrypt($data['password']);

    // Create a new client
    $client = Clients::create($data);

    // Send email
    Mail::to($client->email)->send(new SampleMail($client->fullname));

    return response()->json(['success' => true, 'message' => 'Client created successfully.']);
  }

  public function fetchClient()
  {
    $clients = Clients::all();
    return response()->json([
      'client' => $clients,
    ]);
  }

  public function getClient($id)
  {
    $user = Clients::find($id);

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
    $data = $request->validate([
      'fullname' => 'required',
      'email' => 'required|email',
      'purok' => 'required',
      'metersnumber' => 'required',
    ]);

    // Find the user by ID
    $user = Clients::findOrFail($id);

    // Update the user's information
    $user->update($data);

    // Return success response
    return response()->json(['success' => true, 'message' => 'User updated successfully']);
  }

  public function destroyClient($id)
  {
    Clients::where('id', $id)->delete();

    return response()->json(['success' => true, 'message' => 'User deleted successfully']);
  }
}
