<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    private $name = '';
    private $email = '';
    private $pwss = '';

    protected function set_data_value(String $name = "", String $email = "", String $pwss)
    {
        $this->name = $name;
        $this->email = $email;
        $this->pwss = Hash::make($pwss);
    }

    protected function create()
    {

    }
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:posts|max:255',
            'email' => 'required',
            'pwss' => 'required',
        ]);
    }
}
