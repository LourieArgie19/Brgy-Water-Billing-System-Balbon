<?php

namespace App\Http\Controllers\WBS;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    return view('WBS_content.users');
  }

  public function store(Request $request)
  {
    // Validate the incoming request data
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users,email',
      'usertype' => 'required',
      'password' => 'required|min:5|max:8',
    ]);

    // Hash the password
    $data['password'] = bcrypt($data['password']);

    // Create a new user
    $register = User::create($data);

    // Pass a success message to the view
    return response()->json(['success' => true, 'message' => 'User created successfully.']);
  }

  public function fetchUser()
  {
    $users = User::whereNot('usertype', User::USER_TYPE_CLIENT)->get();
    return response()->json([
      'user' => $users,
    ]);
  }
  public function getUser($id)
  {
    $user = User::find($id);

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

  public function updateUser(Request $request, $id)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users,email,' . $id,
      'usertype' => 'required',
      'password' => 'required|min:5|max:8',
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update the user's information
    $user->update($data);

    // Return success response
    return response()->json(['success' => true, 'message' => 'User updated successfully']);
  }

  public function destroy($id)
  {
    $users = User::where('id', $id)->delete();
  }
}
