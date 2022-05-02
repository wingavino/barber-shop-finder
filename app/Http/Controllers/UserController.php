<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendingRequest;
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

    public function showUsers()
    {
      $data = User::where('type', '!=', 'admin')->paginate(25);
      return view('admin/users', ['data' => $data]);
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
        $pending_request = PendingRequest::where('user_id', '=', $user->id)->where('request_type', 'change-user-type')->first();
        if ($pending_request) {
          $pending_request->rejected = false;
          $pending_request->approved = true;
          $pending_request->save();
          return redirect()->route('admin.pending-requests');
        }
      }
      return redirect()->route('admin.shopowners');
    }
}
