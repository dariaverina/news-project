<?php

namespace RtNews\NewsModule\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return Response::json([
                'status' => 'success',
                'user' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return Response::json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::logout();

        return Response::json(['status' => 'success']);
    }

    public function check()
    {
        if (Auth::check()) {
            $user = Auth::user();

            return Response::json([
                'authenticated' => true,
                'user' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return Response::json(['authenticated' => false, 'user' => null]);
    }
}
