<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\OpenHours;
use App\Models\Queue;
use App\Models\PendingRequest;
use App\Models\Shop;
use App\Models\ShopServices;
use App\Models\User;
use App\Models\Review;
use App\Models\Employee;
use Auth;

class ShopController extends Controller
{
  private $default_days = [1, 2, 3, 4, 5];

  public function showShops()
  {
    $data = DB::table('shops')
                ->leftJoin('users', 'shops.owner_id', '=', 'users.id')
                ->select('shops.*', 'users.id as owner_id', 'users.mobile')
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

  public function showShopsList(Request $request)
  {
    $shops = Shop::where('hidden', false)->get();

    if ($request->type != 'all') {
      $shops = Shop::where('hidden', false)->where('type', $request->type)->get();
    }

    if ($request->services) {
      // Check Each Shop
      foreach ($shops as $shop_key => $shop) {
        // Check Each Service Filter
        foreach ($request->services as $service_key => $service) {
          // Check Shop's Services
          if (!$shop->shop_services->where('category', $service)->first()) {
            $shops->forget($shop_key);
            break;
          }
        }

      }
    }

    if ($request->ajax()) {
      return response()->json(array('shops' => $shops, 'type' => $request->type, ));
    }

    return redirect()->route('home');
  }

  public function showShopLogo(Request $request, $id)
  {
    $shop = Shop::where('id', $id)->first();
    $logo = Image::where('shop_id', $id)->where('type', 'logo')->first();

    if ($request->ajax()) {
      return response()->json($logo);
    }

    return redirect()->route('home');
  }

  public function showShopOpenHours(Request $request, $id)
  {
    $shop = Shop::where('id', $id)->first();
    $open_hours = OpenHours::where('shop_id', $shop->id)->get()->sortBy('day');

    if ($request->ajax()) {
      return response()->json($open_hours);
    }

    return redirect()->route('home');
  }

  public function showShopRatings(Request $request, $id)
  {
    $shop = Shop::where('id', $id)->first();
    $shop_reviews = Review::where('shop_id', $shop->id)->where('hidden', false)->get();
    $review_count = $shop_reviews->count();
    $review_average = round($shop_reviews->avg('rating'), 2);

    if ($request->ajax()) {
      return response()->json(array('review_count' => $review_count, 'review_average' => $review_average));
    }

    return redirect()->route('home');
  }

  public function showShop($id)
  {
    $shop = Shop::where('id', $id)->first();

    if ($shop->hidden) {
      return redirect()->route('home');
    }

    $open_hours = OpenHours::where('shop_id', $id)->get()->sortBy('day');
    $logo = Image::where('shop_id', $id)->where('type', 'logo')->first();

    if (Auth::user() && Auth::user()->type == 'admin') {
      return view('admin/shop', ['shop' => $shop, 'open_hours' => $open_hours, 'logo' => $logo]);
    }else {
      return view('shop', ['shop' => $shop, 'open_hours' => $open_hours, 'logo' => $logo]);
    }

  }

  public function showShopAsShopOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $open_hours = OpenHours::where('shop_id', $shop->id)->get()->sortBy('day');
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('shopowner/shop', ['shop' => $shop, 'open_hours' => $open_hours, 'logo' => $logo]);
  }

  public function showShopAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $open_hours = OpenHours::where('shop_id', $shop->id)->get()->sortBy('day');
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('employee/shop', ['shop' => $shop, 'open_hours' => $open_hours, 'logo' => $logo]);
  }

  public function showShopImages($id)
  {
    $shop = Shop::where('id', $id)->first();
    $images = Image::where('shop_id', $id)->where('type', 'images')->get();
    $logo = Image::where('shop_id', $id)->where('type', 'logo')->first();

    if (Auth::user() && Auth::user()->type == 'admin') {
      return view('admin/shop-images', ['shop' => $shop, 'logo' => $logo, 'images' => $images]);
    }else {
      return view('shop-images', ['shop' => $shop, 'logo' => $logo, 'images' => $images]);
    }
  }

  public function showShopImagesAsShopOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $images = Image::where('shop_id', $shop->id)->where('type', 'images')->get();
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('shopowner/shop-images', ['shop' => $shop, 'images' => $images, 'logo' => $logo]);
  }

  public function showShopImagesAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $images = Image::where('shop_id', $shop->id)->where('type', 'images')->get();
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('employee/shop-images', ['shop' => $shop, 'images' => $images, 'logo' => $logo]);
  }

  public function showShopServices($id)
  {
    $shop = Shop::where('id', $id)->first();
    $shop_services = $shop->shop_services;
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    if (Auth::user() && Auth::user()->type == 'admin') {
      return view('admin/shop-services', ['shop' => $shop, 'shop_services' => $shop_services, 'logo' => $logo]);
    }else {
      return view('shop-services', ['shop' => $shop, 'shop_services' => $shop_services, 'logo' => $logo]);
    }
  }

  public function showShopEmployeesAsShopOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $employees = $shop->employee;

    return view('shopowner.shop-employees', ['shop' => $shop, 'employees' => $employees]);
  }

  public function showShopEmployeesAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $employees = $shop->employee;

    return view('employee.shop-employees', ['shop' => $shop, 'employees' => $employees]);
  }

  public function showAddShopEmployee()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();

    return view('shopowner.shop-employee-add', ['shop' => $shop]);
  }

  public function showShopReviews($id)
  {
    $shop = Shop::where('id', $id)->first();
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();
    $shop_reviews = Review::where('shop_id', $shop->id)->where('hidden', false)->get();
    $review_count = $shop_reviews->count();
    $review_average = $shop_reviews->avg('rating');

    if (Auth::user() && Auth::user()->type =='admin') {
      return view('admin/shop-reviews', ['shop' => $shop, 'logo' => $logo, 'shop_reviews' => $shop_reviews, 'review_count' => $review_count, 'review_average' => $review_average]);
    }else {
      return view('shop-reviews', ['shop' => $shop, 'logo' => $logo, 'shop_reviews' => $shop_reviews, 'review_count' => $review_count, 'review_average' => $review_average]);
    }
  }

  public function showShopReviewsAsOwner()
  {
    $shop = Auth::user()->shop;
    $shop_reviews = Review::where('shop_id', $shop->id)->get();
    $review_count = Review::where('shop_id', $shop->id)->count();
    $review_average = Review::where('shop_id', $shop->id)->avg('rating');

    return view('shopowner.shop-reviews', ['shop' => $shop, 'shop_reviews' => $shop_reviews, 'review_count' => $review_count, 'review_average' => $review_average]);
  }

  public function showShopReviewsAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $shop_reviews = Review::where('shop_id', $shop->id)->get();
    $review_count = Review::where('shop_id', $shop->id)->count();
    $review_average = Review::where('shop_id', $shop->id)->avg('rating');

    return view('employee.shop-reviews', ['shop' => $shop, 'shop_reviews' => $shop_reviews, 'review_count' => $review_count, 'review_average' => $review_average]);
  }

  public function showShopAddReview($id)
  {
    $shop = Shop::where('id', $id)->first();

    return view('shop-reviews-add', ['shop' => $shop,'id' => $shop->id]);
  }

  public function showShopServicesAsOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $shop_services = $shop->shop_services;

    return view('shopowner/shop-services', ['shop' => $shop, 'shop_services' => $shop_services]);
  }

  public function showShopServicesAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $shop_services = $shop->shop_services;

    return view('employee/shop-services', ['shop' => $shop, 'shop_services' => $shop_services]);
  }

  public function showShopQueueAsOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();
    $shop_queue = $shop->queue;
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('shopowner/shop-queue', ['shop' => $shop, 'shop_queue' => $shop_queue, 'logo' => $logo]);
  }

  public function showShopQueueAsEmployee()
  {
    $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
    $shop_queue = $shop->queue;
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('employee/shop-queue', ['shop' => $shop, 'shop_queue' => $shop_queue, 'logo' => $logo]);
  }

  public function showShopQueueAsAdmin($id)
  {
    $shop = Shop::where('id', $id)->first();
    $shop_queue = $shop->queue;
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    return view('admin/shop-queue', ['shop' => $shop, 'shop_queue' => $shop_queue, 'logo' => $logo]);
  }

  public function showAddShopServices($id = null)
  {
    if ($id == null) {
      $shop = Auth::user()->shop;
    }else {
      $shop = Shop::where('id', $id)->first();
    }
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    if (Auth::user()->type == 'shopowner') {
      return view('shopowner/shop-services-add', ['shop' => $shop, 'logo' => $logo]);
    }elseif(Auth::user()->type == 'admin'){
      return view('admin/shop-services-add', ['shop' => $shop, 'logo' => $logo]);
    }else{
      return redirect()->route('shop', ['id' => $shop->id]);
    }
  }

  public function addShopServices(Request $request, $id = null)
  {
    if ($id == null) {
      $shop = Auth::user()->shop;
    }else {
      $shop = Shop::where('id', $id)->first();
    }

    if ($shop) {
      $shop_service = new ShopServices;
      $shop_service->shop_id = $shop->id;
      $shop_service->name = $request->name;
      $shop_service->category = $request->category;
      $shop_service->price = $request->price;
      $shop_service->save();
    }

    if (Auth::user()->type == 'shopowner') {
      return redirect()->route('shopowner.shop.services', ['id' => $shop->id]);
    }elseif(Auth::user()->type == 'admin'){
      return redirect()->route('admin.shop.services', ['id' => $shop->id]);
    }else{
      return redirect()->route('shop,services', ['id' => $shop->id]);
    }
  }

  public function showEditShopServices($service_id, $id = null)
  {
    if (Auth::user()->type == 'shopowner') {
      $shop = Auth::user()->shop;
    }else {
      $shop = Shop::where('id', $id)->first();
    }

    $shop_service = ShopServices::where('shop_id', $shop->id)->where('id', $service_id)->first();

    if (Auth::user()->type == 'shopowner') {
      return view('shopowner/shop-services-edit', ['shop' => $shop, 'shop_service' => $shop_service]);
    }elseif(Auth::user()->type == 'admin'){
      return view('admin/shop-services-edit', ['shop' => $shop, 'shop_service' => $shop_service]);
    }else{
      return redirect()->route('shop,services', ['id' => $shop->id]);
    }
  }

  public function editShopServices(Request $request, $id = null, $service_id)
  {
    if (Auth::user()->type == 'shopowner') {
      $shop = Auth::user()->shop;
    }else {
      $shop = Shop::where('id', $id)->first();
    }

    if ($shop) {
      $shop_service = ShopServices::where('shop_id', $shop->id)->where('id', $service_id)->first();
      if ($shop_service) {
        $shop_service->name = $request->name;
        $shop_service->category = $request->category;
        $shop_service->price = $request->price;
        $shop_service->save();
      }
    }
    if (Auth::user()->type == 'shopowner') {
      return redirect()->route('shopowner.shop.services', ['id' => $shop->id]);
    }elseif(Auth::user()->type == 'admin'){
      return redirect()->route('admin.shop.services', ['id' => $shop->id]);
    }else{
      return redirect()->route('shop,services', ['id' => $shop->id]);
    }
  }

  public function deleteShopServices(Request $request, $id, $service_id)
  {
    if (Auth::user()->type == 'shopowner') {
      $shop = Auth::user()->shop;
    }else {
      $shop = Shop::where('id', $id)->first();
    }

    if ($shop) {
      $shop_service = ShopServices::where('shop_id', $shop->id)->where('id', $service_id)->first();
      if ($shop_service) {
        $shop_service->delete();
      }
    }
    if (Auth::user()->type == 'shopowner') {
      return redirect()->route('shopowner.shop.services', ['id' => $shop->id]);
    }elseif(Auth::user()->type == 'admin'){
      return redirect()->route('admin.shop.services', ['id' => $shop->id]);
    }else{
      return redirect()->route('shop,services', ['id' => $shop->id]);
    }
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
    // $shop = Shop::where('name', '=', $request->name)->first();
    if (Auth::user()->type == 'shopowner') {
      $shop = Shop::where('owner_id', Auth::user()->id)->first();
    }

    if (!isset($shop)) {
      $shop = new Shop();
      $shop->name = $request->name;
      $shop->type = $request->type;

      if (Auth::user()->type == 'admin') {
        // $shop->owner_id = $request->owner_id;
        $shop->owner_name = $request->owner_name;
      }else {
        $shop->owner_id = Auth::user()->id;
        $shop->owner_name = Auth::user()->name;
      }

      $shop->mobile = $request->mobile;
      $shop->address = $request->address;
      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      $shop->save();

      $open_hours_day = $request->input('open_hours_day');
      $open_hours_start = $request->input('open_hours_start');
      $open_hours_end = $request->input('open_hours_end');

      if (!isset($open_hours_day)) {
        $open_hours_day = $this->default_days;
      }
      
      if ($open_hours_day != null) {
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
      }
      else {
        $shop->delete();
        return redirect()->back();
      }

      $queue = new Queue();
      $queue->shop_id = $shop->id;
      $queue->save();

    }
    return redirect()->route('shop', ['id' => $shop->id]);
  }

  public function showEditShop($id, Request $request)
  {
    $shop = Shop::where('id', $id)->first();
    if ($shop) {
      $open_hours = OpenHours::where('shop_id', $shop->id)->get();
      switch (Auth::user()->type) {
        case 'admin':
          $shopowners = User::where('type', '=', 'shopowner')->get();
          return view('admin/shops-edit', ['shop' => $shop, 'shopowners' => $shopowners, 'open_hours' => $open_hours]);
          break;
        case 'shopowner':
          return view('shopowner/shop-edit', ['shop' => $shop, 'open_hours' => $open_hours]);
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
    $shop = Shop::where('id', $id)->first();
    if ($shop) {
      $shop->name = $request->name;
      $shop->type = $request->type;

      if (Auth::user()->type == 'shopowner' && $shop->id == Auth::user()->shop->id) {
        $shop->owner_id = Auth::user()->id;
        $shop->owner_name = Auth::user()->name;
      }else {
        // $shop->owner_id = $request->owner_id;
        $shop->owner_name = $request->owner_name;
      }

      $shop->mobile = $request->mobile;
      $shop->address = $request->address;
      $shop->lat = $request->lat;
      $shop->lng = $request->lng;
      $shop->save();

      foreach ($shop->open_hours as $current_open_hours) {
        $current_open_hours->delete();
      }

      $open_hours_day = $request->input('open_hours_day');
      $open_hours_start = $request->input('open_hours_start');
      $open_hours_end = $request->input('open_hours_end');

      if ($open_hours_day == null) {
        $open_hours_day = $this->default_days;
      }

      foreach ($open_hours_day as $day) {
        $open_hour = OpenHours::where('shop_id', $shop->id)->where('day', $day)->first();
        if (!$open_hour) {
          $open_hour = new OpenHours;
        }
        $open_hour->shop_id = $shop->id;
        $open_hour->day = $day;
        if (isset($open_hours_start[$day])) {
          if ($open_hours_start[$day] != null) {
            $open_hour->time_start = $open_hours_start[$day];
          }
        }
        if (isset($open_hours_end[$day])) {
          if ($open_hours_end[$day] != null) {
            $open_hour->time_end = $open_hours_end[$day];
          }
        }
        $open_hour->save();
      }
    }

    switch (Auth::user()->type) {
      case 'admin':
      return redirect()->route('admin.shop', ['id' => $shop->id]);
      break;

      default:
      return redirect()->route('shopowner.shop');
      break;
    }
  }

  public function showShopSettings($id)
  {
    $shop = Shop::where('id', $id)->first();
    $logo = Image::where('shop_id', $shop->id)->where('type', 'logo')->first();

    if (Auth::user()->type == 'admin') {
      return view('admin/shop-settings', ['shop' => $shop, 'logo' => $logo]);
    }
  }

  public function showShopSettingsAsOwner()
  {
    $shop = Shop::where('owner_id', Auth::user()->id)->first();

    return view('shopowner/shop-settings', ['shop' => $shop]);
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

  public function deleteShopAsOwner(Request $request)
  {
    $shop = Shop::where('id', Auth::user()->shop->id)->first();

    if ($shop) {
      $pending_requests = PendingRequest::where('shop_id', $shop->id)->get();
      if ($pending_requests) {
        foreach ($pending_requests as $pending_request) {
          $pending_request->delete();
        }
      }
      $shop->delete();
    }

    return redirect()->route('home');
  }

  public function approveShop($id)
  {
    $shop = Shop::where('id', '=', $id)->first();
    if ($shop) {
      $shop->approved = true;
      $shop->rejected = false;
      $shop->save();
      $pending_request = PendingRequest::where('shop_id', $id)
                                        ->where('request_type', 'add-new-shop')
                                        ->first();
      $pending_request->approved = true;
      $pending_request->rejected = false;
      $pending_request->save();

      return redirect()->route('admin.pending-requests');
    }
  }
}
