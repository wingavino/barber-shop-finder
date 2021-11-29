<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
      if (Auth::user()->type == 'admin') {
        return view('admin/home');
      }
      else {
        return redirect()->route('home');
      }
    }
}
