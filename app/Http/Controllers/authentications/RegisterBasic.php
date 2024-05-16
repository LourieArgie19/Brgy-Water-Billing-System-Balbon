<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function store(Request $request)
  {
    $validateDate = $request->validate([
      'username' => 'required',
      'email' => 'required',
      'password' => 'required',
    ]);

    $data = new User();

    $data->username = $validateDate['username'];
    $data->email = $validateDate['email'];
    $data->password = $validateDate['password'];

    $data->save();

    return response() - json(['message' => 'Data saved successfully'], 200);
  }
}