<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $books = [
            'Harry Potter',
            'Laravel'
        ];
        // 데이터 전송 방법 1 )
        // return view('welcome', [
        //     'books' => $books
        // ]);

        // 데이터 전송 방법 1 )
        return view('welcome')->with([
            'books' => $books
        ]);
    }

    public function hello() {
        return view('hello');
    }

    public function contact()
    {
        return view('contact');
    }
}
