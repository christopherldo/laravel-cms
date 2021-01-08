<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Visitor;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request, $slug)
    {
        $visitor = new Visitor;
        $visitor->ip = $request->ip();
        $visitor->date_access = date('Y-m-d H:i:s');
        $visitor->page = '/' . $slug;
        $visitor->save();

        $page = Page::where('slug', $slug)->first();

        if($page){
            return view('site.page', [
                'page' => $page
            ]);
        } else {
            abort(404);
        };
    }
}
