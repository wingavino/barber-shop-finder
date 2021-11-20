<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // User
    public function index(User $user)
    {
        return view('user');
    }
}
