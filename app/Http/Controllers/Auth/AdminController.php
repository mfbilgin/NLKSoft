<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function productAdd(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.product-add');
    }
    public function productList(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.product-list');
    }
    public function categoryAdd(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.category-add');
    }
    public function categoryList(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.category-list');
    }
    public function userList(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.user.user-list');
    }

    public function deleteUser($id): RedirectResponse
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('admin.user.list')->with('info', 'User deleted successfully.');
    }

    public function changeRole($id,$newRole)
    {
        $user = User::find($id);
        if($user){
            $user->role = $newRole;
            $user->save();
        }
        return redirect()->route('admin.user.list')->with('info', 'Role changed successfully.');
    }
}
