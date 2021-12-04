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
    $data = DB::table('users')->get();
    return view('admin/shop-owners', ['data' => $data]);
  }

  public function showShopOwnersAdd()
  {
    return view('admin/shop-owners-add');
  }

  public function showEditShopOwners($id, $type)
  {
    $user = User::where('id', '=', $id)->first();
    return view('admin/shop-owners-edit', ['user' => $user, 'type' => $type]);
  }
}
