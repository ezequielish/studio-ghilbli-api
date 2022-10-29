<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected function createOrUpdate(array $values, $update = false)
    {
        try {
            if ($update) {
                $user_model = User::find(Auth::id());
            } else {
                $user_model = new User();
            }

            $user_model->name = isset($values['name']) ? $values['name'] : $user_model->name;
            $user_model->email = isset($values['email']) ? $values['email'] : $user_model->email;
            $user_model->password = isset($values['pwss']) ? Hash::make($values['pwss']) : $user_model->password;
            $user_model->save();

            return true;
        } catch (\Throwable$th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
    public function index(Request $request)
    {
        try {
            $inputs = $request->all();
            $validate = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'pwss' => 'required|min:6',
            ]);

            $this->validate_fk($validate);
            $created = $this->createOrUpdate($validate);

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

    public function update(Request $request)
    {
        $inputs = $request->all();

        $validate = $request->validate([
            'name' => 'max:255',
            'email' => 'email',
            'pwss' => 'min:6',
        ]);

        $updated = $this->createOrUpdate($validate, true);

        if ($updated) {
            return response()->json([
                'error' => false,
                'message' => 'User updated successfully',
            ], 200);
        }

    }

    public function user_delete(Request $request)
    {

        try {

            $user_selected = User::find(Auth::id());

            if (empty($user_selected)) {
                throw new Exception('user no exists', 400);
            }

            $user_selected->delete();

            return response()->json([
                'error' => false,
                'message' => 'deleted user',
            ], 200);

        } catch (\Throwable$th) {
            throw $th;
        }

    }
}
