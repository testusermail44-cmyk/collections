<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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
        return back()->with('success', 'Статус користувача оновлено')->with('type', 0);
    }

    public function categoriesIndex()
    {
        if (auth()->user()->is_admin < 1)
            abort(403);
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function categoryCreate()
    {
        if (auth()->user()->is_admin < 1)
            abort(403);
        return view('admin.editor');
    }

    public function categoryEdit(Category $category)
    {
        if (auth()->user()->is_admin < 1)
            abort(403);
        return view('admin.editor', compact('category'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required|max:255|unique:categories']);
        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Категорію створено')->with('type', 2);
    }

    public function categoryUpdate(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|max:255|unique:categories,name,' . $category->id]);
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Категорію оновлено')->with('type', 2);
    }

    public function categoryDestroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Категорію видалено')->with('type', 2);
    }
}