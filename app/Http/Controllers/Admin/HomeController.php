<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Page;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $onlineCount = 0;
        $visitsCount = 0;
        $pageCount = 0;
        $userCount = 0;

        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupBy('ip')->get();
        $onlineCount = count($onlineList);

        $visitsCount = Visitor::count();
        $pageCount = Page::count();
        $userCount = User::count();

        $pagePie = [
            'Teste 1' => 100,
            'Teste 2' => 200,
            'Teste 3' => 300
        ];

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));

        return view('admin.home', [
            'onlineCount' => $onlineCount,
            'visitsCount' => $visitsCount,
            'pageCount' => $pageCount,
            'userCount' => $userCount,
            'pageLabels' => $pageLabels,
            'pageValues' => $pageValues
        ]);
    }
}
