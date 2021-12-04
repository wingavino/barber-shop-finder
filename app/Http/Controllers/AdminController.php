<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use Auth;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin/home');
  }

  public function showShopOwners()
  {
    $data = DB::table('users')->where('type', 'shopowner')->get();
    return view('admin/shop-owners', ['data' => $data]);
  }

  public function showShopOwnersAdd()
  {
    return view('admin/shop-owners-add');
  }
}
