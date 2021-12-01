<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Auth;

class AdminController extends Controller
{
    public function redirectToIfAdmin(String $redirect)
    {
      if (!Auth::user()->type == 'admin') {
        return redirect()->route('home');
      }else {
        return view($redirect);
      }
    }

    public function index()
    {
      // return $this->redirectToIfAdmin('admin/home');
      if (Auth::user()->type == 'admin') {
        return view('admin/home');
      }else {
        return redirect()->route('home');
      }
    }

    public function showShopOwners()
    {
      // return $this->redirectToIfAdmin('admin/shop-owners');
      if (Auth::user()->type == 'admin') {
        $data = DB::table('users')->where('type', 'shopowner')->get();
        return view('admin/shop-owners', ['data' => $data]);
      }else {
        return view('home');
      }
    }

    public function showShops()
    {
      return view('admin/shops');
    }

}
