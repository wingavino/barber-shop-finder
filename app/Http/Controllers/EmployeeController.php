<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Employee;
use App\Models\User;
use Auth;

class EmployeeController extends Controller
{
  public function addShopEmployee(Request $request)
  {
    $shop = Auth::user()->shop;
    if ($shop) {
      $employee = new Employee;
      $employee->shop_id = $shop->id;
      if ($request->email) {
        $employee->email = $request->email;
        $link_user = User::where('email', $employee->email)->first();
        if ($link_user->type == 'user') {
          $employee->user_id = $link_user->id;
        }
      }

      $employee->name = $request->name;
      $employee->type = $request->type;
      $employee->save();
    }
    return redirect()->route('shopowner.shop.employees');
  }

  public function deleteShopEmployee(Request $request, $id)
  {
    $shop = Auth::user()->shop;
    if ($shop) {
      $employee = Employee::where('shop_id', $shop->id)->where('id', $id)->first();
      if ($employee) {
        $employee->delete();
      }
    }
    return redirect()->route('shopowner.shop.employees');
  }

  public function showEditShopEmployee($id)
  {
    $shop = Auth::user()->shop;
    $employee = Employee::where('shop_id', $shop->id)->where('id', $id)->first();

    return view('shopowner/shop-employees-edit', ['shop' => $shop, 'employee' => $employee]);
  }

  public function editShopEmployee(Request $request, $id)
  {
    $shop = Auth::user()->shop;
    if ($shop) {
      $employee = Employee::where('shop_id', $shop->id)->where('id', $id)->first();
      if ($employee) {
        $employee->name = $request->name;
        $employee->type = $request->type;
        if ($request->email) {
          $employee->email = $request->email;
          $link_user = User::where('email', $employee->email)->first();
          if ($link_user) {
            if ($link_user->type == 'user') {
              $employee->user_id = $link_user->id;
            }
          }
        }
        $employee->save();
      }
    }
    return redirect()->route('shopowner.shop.employees');
  }
}
