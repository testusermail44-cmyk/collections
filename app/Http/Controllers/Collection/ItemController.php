<?php

namespace App\Http\Controllers\Collection;

use App\Models\Collection;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $item = $collection->items()->create([
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
        ]);
        if ($request->hasFile('images')) {
            $this->uploadImages($request->file('images'), $item);
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
        ]);
        if ($request->hasFile('images')) {
            $this->uploadImages($request->file('images'), $item);
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

    private function uploadImages($files, $item)
    {
        $files = is_array($files) ? $files : [$files];
        foreach ($files as $image) {
            $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
                'key' => env('IMGBB_API_KEY'),
                'image' => base64_encode(file_get_contents($image->getRealPath())),
            ]);
            if ($response->successful()) {
                $item->images()->create(['url' => $response->json()['data']['url']]);
            }
        }
    }
}