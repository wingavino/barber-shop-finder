<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Employee;
use Auth;

class EmployeeController extends Controller
{
  public function addShopEmployee(Request $request)
  {
    $shop = Auth::user()->shop;
    if ($shop) {
      $employee = new Employee;
      $employee->shop_id = $shop->id;
      if ($request->user_id) {
        $employee->user_id = $request->user_id;
      }
      $employee->name = $request->name;
      $employee->type = $request->type;
      $employee->save();
    }
    return redirect()->route('shopowner.shop.employees');
  }
}
