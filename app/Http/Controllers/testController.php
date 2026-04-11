<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function getSessionValue()
    {
        $val = session('test-sess');
        return view('test2', ['val' => $val]);
    }
}
