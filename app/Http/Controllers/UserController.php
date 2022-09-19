<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private function validate_fk(array $inputs)
    {
        $user_exist = User::where('email', $inputs['email'])->first();

        if (!empty($user_exist)) {

            throw new Exception('user exists', 400);
        }
    }
    protected function create(array $values)
    {
        try {
            $model = new User();
            $model->name = $values['name'];
            $model->email = $values['email'];
            $model->password = Hash::make($values['pwss']);
            $model->save();

            return true;
        } catch (\Throwable$th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
    public function index(Request $request)
    {
        try {
            $inputs = $request->all();
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'pwss' => 'required|min:6',
            ]);

            $values = [
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'pwss' => $inputs['pwss'],
            ];

            $this->validate_fk($inputs);
            $created = $this->create($values);

            if ($created) {
                return response()->json([
                    'error' => false,
                    'message' => 'User created successfully',
                ], 201);
            }

        } catch (\Throwable$th) {
            throw $th;
        }
    }
}
