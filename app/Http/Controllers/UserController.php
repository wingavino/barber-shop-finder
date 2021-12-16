<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    // User
    public function index(User $user)
    {
        return view('user');
    }

    public function showUserEdit(User $user)
    {
      return view('user-edit');
    }

    public function showUserEditPassword(User $user)
    {
      return view('user-edit-password');
    }

    public function editUser(Request $request)
    {
      $user = Auth::user();
      $user->name = $request->name;
      $user->mobile = $request->mobile;
      // $user->email = $request->email;
      $user->save();
      return redirect('user');
    }

    public function editUserPassword(Request $request)
    {
      $user = Auth::user();
      $validated = $request->validate([
        'oldpassword' => 'nullable|current_password',
        'password' => 'required|string|min:8|confirmed'
      ]);
      $user->password = Hash::make($request->password);
      $user->save();
      return redirect('user');
    }

    public function changeUserType($id, $type, Request $request)
    {
      $user = User::where('id', '=', $id)->first();
      if ($user) {
        $user->type = $type;
        $user->save();
      }
      return redirect()->route('admin.shopowners');
    }
}
