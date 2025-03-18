<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      return view('home');
    }

    public function showPrivacyPolicy()
    {
      return view('privacy-policy');
    }

    public function showShopOwnerPrivacyPolicy()
    {
      return view('shopowner/privacy-policy');
    }

    public function showTerms()
    {
      return view('terms');
    }

    public function showShopOwnerTerms()
    {
      return view('shopowner/terms');
    }
}
