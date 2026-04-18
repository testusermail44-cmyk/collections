<?php
namespace App\Http\Controllers\Collection;

use App\Models\Collection;
use App\Models\Category;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        return view('collections.collectionEditor', compact('categories'));
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'Введіть назву колекції',
            'category_id.required' => 'Потрібно обрати категорію',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('type', 1);
        }

        $collection = Collection::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_public' => $request->has('is_public') ? 1 : 0,
        ]);
        return redirect()->route('items.create', ['collection' => $collection->id])
            ->with('success', 'Колекцію успішно створено! Тепер додайте перший предмет')
            ->with('type', 2);
    }

    public function edit(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::orderBy('id', 'asc')->get();
        return view('collections.collectionEditor', compact('categories', 'collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }
        $messages = [
            'title.required' => 'Введіть назву колекції',
            'category_id.required' => 'Потрібно обрати категорію',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ], $messages);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('type', 1);
        }
        $collection->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_public' => $request->has('is_public') ? 1 : 0,
        ]);
        return redirect()->route('collections.my')
            ->with('success', 'Колекцію оновлено!')
            ->with('type', 2);
    }

    public function destroy(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }
        $collection->delete();
        return redirect()->route('collections.my')
            ->with('success', 'Колекцію видалено')->with('type', 2);
    }
    public function index(Request $request)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $isMyCollections = $request->routeIs('collections.my');
        $query = Collection::with(['user', 'items.images'])
            ->latest();
        if ($isMyCollections) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('is_public', true)
                ->when($request->search, function ($q, $search) {
                    $q->where(function ($inner) use ($search) {
                        $inner->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->when($request->category && $request->category != 0, function ($q, $category) {
                    $q->where('category_id', $category);
                });
        }
        $publicCollections = $query->paginate(10)->withQueryString();
        return view('collections.collections', compact('publicCollections', 'categories', 'isMyCollections'));
    }
    public function show(Request $request, Collection $collection)
    {
        $isMyCollection = $request->routeIs('collections.elements.my');
        $items = $collection->items()
            ->with('images')
            ->latest()
            ->paginate(20);
        return view('collections.collection', compact('collection', 'items', 'isMyCollection'));
    }
    public function showItem(Item $item)
    {
        $item->load(['images', 'collection.user', 'comments.user']);
        return view('collections.item', compact('item'));
    }

    public function storeComment(Request $request, Item $item)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Коментар додано!')->with('type', 2);
    }

    public function destroyComment(Comment $comment)
    {
        if (auth()->user()->is_admin >= 1 || $comment->user_id === auth()->id()) {
            $comment->delete();
            return back()->with('success', 'Коментар видалено')->with('type', 2);
        }
        abort(403, 'У вас немає прав на цю дію');
    }
}
?>