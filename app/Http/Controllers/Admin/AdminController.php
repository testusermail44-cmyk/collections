<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

   public function usersIndex()
    {
        if (auth()->user()->is_admin < 1) {
            abort(403);
        }
        $users = User::where('is_admin', '!=', 2)
            ->orderBy('is_admin', 'desc')
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if (auth()->user()->is_admin < 1 || $user->is_admin == 2 || $user->id === auth()->id()) {
            abort(403, 'Дія заборонена');
        }
        $newStatus = ($user->is_admin == 1) ? 0 : 1;
        $user->update([
            'is_admin' => $newStatus
        ]);
        return back()->with('success', 'Статус користувача оновлено');
    }
}