<?php

namespace App\Http\Controllers;

use App\Traits\ScopeTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function generate_public_token(Request $request)
    {
        $public_scope = ScopeTrait::publicScope();
        $token = $request->user()->createToken('public', $public_scope)->plainTextToken;
        $data = [
            'token' => $token,
            'scope' => $public_scope,
            'user' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ];

        return $data;
    }
    public function index(Request $request)
    {
        try {

            $data = $this->generate_public_token($request);
            return response()->json([
                'error' => false,
                'message' => 'OK',
                'data' => $data,
            ], 200);
        } catch (\Throwable$th) {
            throw $th;
        }
    }
}
