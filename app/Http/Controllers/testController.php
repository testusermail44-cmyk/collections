<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class testController extends Controller
{
    public function calculate()
    {
        
        $radius = 10;
        $pi = 3.14;
      
        $result = $pi * ($radius ** 2);

        session(['test-sess' => 'it`s alive']);
        return view('test', [
            'answer' => $result,
            'r' => $radius
        ]);
    }

   public function upload(Request $request)
    {
        $request->validate([
            'my_file' => 'required|image|max:10240',
            'item_name' => 'required|string|max:255',
        ]);

        // 1. Завантаження на ImgBB
        $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
            'key' => env('IMGBB_API_KEY'),
            'image' => base64_encode(file_get_contents($request->file('my_file')->path())),
        ]);

        if ($response->successful()) {
            $url = $response->json()['data']['url'];

            // 2. ЗАПИС У БАЗУ ДАНИХ (items)
            Item::create([
                'name' => $request->item_name,
                'collection' => 1, // Тимчасово ставимо 1, поки немає вибору колекцій
                'image' => $url,
            ]);

            return back()->with('success', 'Збережено в базі даних!');
        }

        return back()->with('error', 'Помилка завантаження.');
    }

    public function getSessionValue()
    {
        $val = session('test-sess');
        // Отримуємо ВСІ предмети з бази даних
        $dbItems = Item::all(); 
        
        return view('test2', [
            'val' => $val,
            'dbItems' => $dbItems
        ]);
    }
}
