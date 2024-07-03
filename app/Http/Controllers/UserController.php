<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function showUserListPage(): Factory|\Illuminate\Foundation\Application|View|Application
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

    public function changeRole($id,$newRole): RedirectResponse
    {
        $user = User::find($id);
        if($user){
            $user->role = $newRole;
            $user->save();
        }
        return redirect()->route('admin.user.list')->with('info', 'Role changed successfully.');
    }
}
