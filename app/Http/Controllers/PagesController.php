<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController
{
    //

    public function index(){
        $text = "hello from Ashour";
        return view('pages.index')->with('text', $text);
    }

    public function about(){
        return view('pages.about');
    }

    public function services(){
        $data = ['services'=> ['creating','reading']];
        return view('pages.services')->with($data);
    }
}
