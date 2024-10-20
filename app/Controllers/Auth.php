<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        // Logika untuk login
    }

    public function logout()
    {
        // Logika untuk logout
    }
}
