<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedId = Auth::id();
        $user = User::find($loggedId);

        $pages = Page::paginate(10);

        return view('admin.pages.index', [
            'pages' => $pages,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['title', 'body']);

        $data['slug'] = Str::slug($data['title'], '-');

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'body' => ['string'],
            'slug' => ['required', 'string', 'max:100', 'unique:pages'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('pages.create')->withErrors($validator)->withInput();
        };

        $page = new Page;
        $page->title = $data['title'];
        $page->slug = $data['slug'];
        $page->body = $data['body'];
        $page->created_by = Auth::id();
        $page->save();

        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loggedId = Auth::id();
        $user = User::find($loggedId);

        $page = Page::find($id);

        if ($page && ($loggedId === $page->created_by || $user->admin === 1)) {
            return view('admin.pages.edit', [
                'page' => $page
            ]);
        };

        return redirect()->route('pages.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loggedId = Auth::id();
        $user = User::find($loggedId);

        $page = Page::find($id);

        if ($page && ($loggedId === $page->created_by || $user->admin === 1)) {
            $data = $request->only(['title', 'body']);

            if ($page->title !== $data['title']) {
                $data['slug'] = Str::slug($data['title'], '-');

                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string'],
                    'slug' => ['required', 'string', 'max:100', 'unique:pages']
                ]);
            } else {
                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string']
                ]);
            }

            if ($validator->fails()) {
                return redirect()->route('pages.edit', ['page' => $id])
                    ->withErrors($validator)->withInput();
            };

            $page->title = $data['title'];
            $page->body = $data['body'];

            if (isset($data['slug'])) {
                $page->slug = $data['slug'];
            };

            $page->save();
        };

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedId = Auth::id();
        $user = User::find($loggedId);

        $page = Page::find($id);

        if($loggedId === $page->created_by || $user->admin === 1){
            $page->delete();
        };

        return redirect()->route('pages.index');
    }
}
