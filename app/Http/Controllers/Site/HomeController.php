<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $visitor = new Visitor;
        $visitor->ip = $request->ip();
        $visitor->date_access = date('Y-m-d H:i:s');
        $visitor->page = '/';
        $visitor->save();

        return view('site.home');
    }
}
