<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthSignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Submodules\PhpHelpers\Traits\ApiResponse;

class AuthController extends Controller
{
  use ApiResponse;

  public function signup(AuthSignupRequest $request)
  {
    try {
      DB::beginTransaction();
      $user = User::create($request->all());

      Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
      ]);

      $token = $user->createToken('apiToken')->plainTextToken;

      $response = [
        'name' => $user->name,
        'email' => $user->email,
        'token' => $token,
      ];
      DB::commit();

      return $this->successResponse($response);
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->errorResponse('Something was wrong!', $th->getMessage());
    }
  }

  public function login(AuthLoginRequest $request)
  {
    try {
      if (!Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
      ]))
        throw new \Exception('No login');

      $user = Auth::user();
      if (!$user instanceof \App\Models\User) throw new \Exception('Something was wrong');

      $token = $user->createToken('apiToken')->plainTextToken;

      $response = [
        'name' => $user->name,
        'email' => $user->email,
        'token' => $token,
      ];

      return $this->successResponse($response);
    } catch (\Throwable $th) {
      return $this->errorResponse('Something was wrong!', $th->getMessage());
    }
  }
}
