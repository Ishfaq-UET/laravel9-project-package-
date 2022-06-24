<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about(){
        return view('pages.about', ['message'=>'This is a message from', 'name'=>'pages controller']);
    }
    public function contact(){
        return 'contact page';
    }
    public function gallery(){
        return 'gallery page';
    }
    public function services(){
        return 'services page';
    }

}
