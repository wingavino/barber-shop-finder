<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OpenHours;
use App\Models\PendingRequest;
use App\Models\Shop;
use App\Models\ShopServices;
use App\Models\User;
use App\Models\Image;
use Auth;

class ShopController extends Controller
{
  public function showShops()
  {
    $data = DB::table('shops')
                ->leftJoin('users', 'shops.owner_id', '=', 'users.id')
                ->select('shops.*', 'users.id as owner_id', 'users.name as owner_name', 'users.mobile')
                ->get();
    switch (Auth::user()->type) {
      case 'admin':
        return view('admin/shops', ['data' => $data]);
        break;

      default:
        return view('shops', ['data' => $data]);
        break;
    }
  }

  public function showShop($id)
  {
    $shop = Shop::where('id', $id)->first();
    $open_hours = OpenHours::where('shop_id', $id)->get()->sortBy('day');

    return view('shop', ['shop' => $shop, 'open_hours' => $open_hours]);
  }

  public function showShopAsShopOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $open_hours = OpenHours::where('shop_id', $shop->id)->get()->sortBy('day');

    return view('shopowner/shop', ['shop' => $shop, 'open_hours' => $open_hours]);
  }

  public function showShopImages($id)
  {
    $shop = Shop::where('id', $id)->first();
    $images = Image::where('shop_id', $id)->get();

    return view('shop-images', ['shop' => $shop, 'images' => $images]);
  }

  public function showShopImagesAsShopOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $images = Image::where('shop_id', $shop->id)->get();

    return view('shopowner/shop-images', ['shop' => $shop, 'images' => $images]);
  }

  public function showShopServices()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $shop_services = $shop->shop_services;

    return view('shopowner/shop-services', ['shop' => $shop, 'shop_services' => $shop_services]);
  }

  public function showAddShopServices()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();

    return view('shopowner/shop-services-add', ['shop' => $shop]);
  }

  public function addShopServices(Request $request)
  {
    $shop = Auth::user()->shop;
    if ($shop) {
      $shop_service = new ShopServices;
      $shop_service->shop_id = $shop->id;
      $shop_service->name = $request->name;
      $shop_service->price = $request->price;
      $shop_service->save();
    }
    return redirect()->route('shopowner.shop.services');
  }

  public function showShopEdit()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $open_hours = OpenHours::where('shop_id', $shop->id)->get();

    return view('shopowner/shop-edit', ['shop' => $shop, 'open_hours' => $open_hours]);
  }

  public function showShopsAdd()
  {
    switch (Auth::user()->type) {
      case 'admin':
        $shopowners = User::where('type', '=', 'shopowner')->get();
        return view('admin/shops-add', ['shopowners' => $shopowners]);
        break;

      default:
        return view('shops-add');
        break;
    }
  }

  public function showShopAddPage()
  {
    switch (Auth::user()->type) {
      case 'admin':
        $shopowners = User::where('type', '=', 'shopowner')->get();
        return view('admin/shops-add', ['shopowners' => $shopowners]);
        break;

      default:
        return view('shopowner/shop-add');
        break;
    }
  }

  public function addShop(Request $request)
  {
    $shop = Shop::where('name', '=', $request->name)->first();
    if (!$shop) {
      $shop = new Shop();
      $shop->name = $request->name;

      if ($shop->owner_id) {
        $shop->owner_id = $request->owner_id;
      }else {
        $shop->owner_id = Auth::user()->id;
      }

      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      $shop->save();

      $open_hours_day = $request->input('open_hours_day');
      $open_hours_start = $request->input('open_hours_start');
      $open_hours_end = $request->input('open_hours_end');

      foreach ($open_hours_day as $day) {
        $open_hour = new OpenHours;
        $open_hour->shop_id = $shop->id;
        $open_hour->day = $day;
        if ($open_hours_start[$day] != null) {
          $open_hour->time_start = $open_hours_start[$day];
        }

        if ($open_hours_end[$day] != null) {
          $open_hour->time_end = $open_hours_end[$day];
        }
        $open_hour->save();
      }

      $pending_request = new PendingRequest();
      $pending_request->user_id = Auth::user()->id;
      $pending_request->request_type = 'add-new-shop';
      $pending_request->shop_id = $shop->id;
      $pending_request->save();

      return redirect()->route('shopowner.shop');
    }
  }

  public function showEditShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      switch (Auth::user()->type) {
        case 'admin':
          $shopowners = User::where('type', '=', 'shopowner')->get();
          return view('admin/shops-edit', ['shop' => $shop, 'shopowners' => $shopowners]);
          break;

        default:
          return view('shops-edit', ['shop' => $shop]);
          break;
      }
    }else {
      return redirect()->route('home');
    }
  }

  public function editShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      $shop->name = $request->name;
      $shop->owner_id = Auth::user()->id;
      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      $shop->save();

      $open_hours_day = $request->input('open_hours_day');
      $open_hours_start = $request->input('open_hours_start');
      $open_hours_end = $request->input('open_hours_end');

      foreach ($open_hours_day as $day) {
        $open_hour = OpenHours::where('shop_id', $shop->id)->where('day', $day)->first();
        if (!$open_hour) {
          $open_hour = new OpenHours;
        }
        $open_hour->shop_id = $shop->id;
        $open_hour->day = $day;
        if ($open_hours_start[$day] != null) {
          $open_hour->time_start = $open_hours_start[$day];
        }

        if ($open_hours_end[$day] != null) {
          $open_hour->time_end = $open_hours_end[$day];
        }
        $open_hour->save();
      }
    }

    switch (Auth::user()->type) {
      case 'admin':
      return redirect()->route('admin.shops');
      break;

      default:
      return redirect()->route('shopowner.shop');
      break;
    }
  }

  public function showDeleteShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      return view('shops-delete', ['shop' => $shop, 'id' => $id]);
    }else {
      return redirect()->route('home');
    }
  }

  public function deleteShop($id, Request $request)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
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

  public function approveShop($id)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      $shop->approved = true;
      $shop->save();
      $pending_request = PendingRequest::where('shop_id', $id)
                                        ->where('request_type', 'add-new-shop')
                                        ->first();
      $pending_request->delete();

      return redirect()->route('admin.pending-requests');
    }
  }
}
