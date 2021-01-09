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

    public function index(Request $request)
    {
        $onlineCount = 0;
        $visitsCount = 0;
        $pageCount = 0;
        $userCount = 0;

        $filterDate = $request->input('filter-date', '-1 day');

        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));

        $onlineList = Visitor::select('ip')->where('date_access', '>=', $datelimit)->groupBy('ip')->get();
        $onlineCount = count($onlineList);

        $visitsFilter = date('Y-m-d H:i:s', strtotime($filterDate));

        if ($visitsFilter < date('Y-m-d H:i:s', strtotime('-6 months'))) {
            $visitsFilter = date('Y-m-d H:i:s', strtotime('-6 months'));
            $filterDate = '-6 months';
        };

        $visitsCount = Visitor::where('date_access', '>=', $visitsFilter)->count();

        $pageCount = Page::count();
        $userCount = User::count();

        $pagePie = [];
        $pageColors = [];

        $visitsAll = Visitor::selectRaw('page, count(page) as c')
            ->where('date_access', '>=', $visitsFilter)->groupBy('page')->get();

        foreach ($visitsAll as $visit) {
            $pagePie[$visit['page']] = intval($visit['c']);
            $pageColors[] = $this->generateRandomColor();
        };

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));
        $pageColors = json_encode(array_values($pageColors));

        return view('admin.home', [
            'onlineCount' => $onlineCount,
            'visitsCount' => $visitsCount,
            'pageCount' => $pageCount,
            'userCount' => $userCount,
            'pageLabels' => $pageLabels,
            'pageValues' => $pageValues,
            'pageColors' => $pageColors,
            'filterDate' => $filterDate,
        ]);
    }

    protected function generateRandomColor()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
