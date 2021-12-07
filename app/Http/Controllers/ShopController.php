<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use Auth;

class ShopController extends Controller
{
  public function showShops()
  {
    $data = DB::table('shops')->get();
    switch (Auth::user()->type) {
      case 'admin':
        return view('admin/shops', ['data' => $data]);
        break;

      default:
        return view('shops', ['data' => $data]);
        break;
    }
  }

  public function showShopsAdd()
  {
    switch (Auth::user()->type) {
      case 'admin':
        return view('admin/shops-add');
        break;

      default:
        return view('shops-add');
        break;
    }
  }

  public function addShop(Request $request)
  {
    $shop = Shop::where('name', '=', $request->name)->first();
    if (!$shop) {
      $shop = new Shop();
      $shop->name = $request->name;
      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      // $shop->location = DB::raw('GeomFromText(POINT($request->lat, $request->lng))');
      $shop->save();
      return redirect()->route('admin.shops');
    }
  }

  public function showEditShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      return view('shops-edit', ['shop' => $shop]);
    }else {
      return redirect()->route('home');
    }
  }

  public function editShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      $shop->name = $request->name;
      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      $shop->save();
    }

    switch (Auth::user()->type) {
      case 'admin':
      return redirect()->route('admin.shops');
      break;

      default:
      return redirect()->route('home');
      break;
    }
  }

  public function showDeleteShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      return view('shops-delete', ['name' => $shop->name, 'id' => $id]);
    }else {
      return redirect()->route('home');
    }
  }

  public function deleteShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      if ($request->confirm == $shop->name) {
        $shop->delete();

        switch (Auth::user()->type) {
          case 'admin':
          return redirect()->route('admin.shops');
          break;

          default:
          return redirect()->route('shops');
          break;
        }
      }
    }
  }
}
