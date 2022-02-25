<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Userl;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  /**
   * Store a newly created user and send the access token
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $fields = $request->validate([
      'name' => 'required|string',
      'email' => 'required|string|unique:users,email',
      'password' => 'required|string|confirmed',
    ]);
    $user = User::create([
      'name' => $fields['name'],
      'email' => $fields['email'],
      'password' => bcrypt($fields['password']),
    ]);
    $token = $user->createToken('myApptoken')->plainTextToken;
    
    return \response()->json([
      'user' => $user,
      'token' => $token,
    ]);
    
  }
  
  /**
   * Kill the access token
   *
   * @return \Illuminate\Http\Response
   */
  public function logout()
  {
    auth()->user()->tokens()->delete();
    
    return \response()->json(['message' => 'successfully deleted']);
  }
  
  /**
   * Kill the access token
   *
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $fields = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);
    
    $user = User::where('email', $fields['email'])->first();
    
    if (!$user || !Hash::check($fields['password'], $user->password)) {
      return \response()->json(['message' => 'invalid creds']);
    }
    $token = $user->createToken('myApptoken')->plainTextToken;
    
    return \response()->json([
      'user' => $user,
      'token' => $token,
    ]);
    
  }
}
