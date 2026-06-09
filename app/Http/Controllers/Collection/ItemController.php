<?php

namespace App\Http\Controllers\Collection;

use App\Models\Collection;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function create(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }
        return view('collections.itemEditor', compact('collection'));
    }

    public function store(Request $request, Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|string',
            'condition' => 'required|integer',
            'uploaded_images' => 'required|array',
            'uploaded_images.*' => 'url',
        ]);

        $item = $collection->items()->create([
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
        ]);

        if ($request->has('uploaded_images')) {
            foreach ($request->uploaded_images as $url) {
                $item->images()->create(['url' => $url]);
            }
        }

        return redirect()->route('collections.elements.my', $collection->id)->with('success', 'Предмет додано!')->with('type', 2);
    }

    public function edit(Item $item)
    {
        if ($item->collection->user_id !== auth()->id()) {
            abort(403);
        }
        $collection = $item->collection;
        return view('collections.itemEditor', compact('item', 'collection'));
    }

    public function destroyImage(ItemImage $image)
    {
        if (!$image->item || $image->item->collection->user_id !== auth()->id()) {
            abort(403, 'У вас немає прав на видалення цього фото');
        }
        $image->delete();
        return back()->with('success', 'Фото видалено')->with('type', 2);
    }

    public function update(Request $request, Item $item)
    {
        if ($item->collection->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|string',
            'condition' => 'required|integer',
            'uploaded_images' => 'nullable|array',
            'uploaded_images.*' => 'url',
        ]);

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
        ]);

        if ($request->has('uploaded_images')) {
            foreach ($request->uploaded_images as $url) {
                $item->images()->create(['url' => $url]);
            }
        }

        return redirect()->route('collections.elements.my', $item->collection_id)->with('success', 'Предмет оновлено!')->with('type', 2);
    }

    public function destroy(Item $item)
    {
        if ($item->collection->user_id !== auth()->id()) {
            abort(403);
        }
        $item->images()->delete();
        $item->delete();
        return back()->with('success', 'Предмет видалено!')->with('type', 2);
    }
}
