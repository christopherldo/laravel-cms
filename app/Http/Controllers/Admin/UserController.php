<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
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
        $loggedId = intval(Auth::id());
        $user = User::find($loggedId);

        if($user->admin === 1){
            $users = User::paginate(10);

            return view('admin.users.index', [
                'users' => $users,
                'loggedId' => $loggedId
            ]);
        };

        return redirect()->route('admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.create')->withErrors($validator)->withInput();
        };

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index');
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
        $user = User::find($id);

        if ($user) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        };

        return redirect()->route('users.index');
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
        $user = User::find($id);

        if ($user) {
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ], [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100']
            ]);

            $user->name = $data['name'];

            if ($user->email !== $data['email']) {
                $hasEmail = User::where('email', $data['email'])->get();

                if (count($hasEmail) === 0) {
                    $user->email = $data['email'];
                } else {
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email',
                    ]));
                };
            };

            if (empty($data['password']) === false) {
                if (strlen($data['password']) >= 8) {
                    if(strlen($data['password']) <= 100){
                        if ($data['password'] === $data['password_confirmation']) {
                            $user->password = Hash::make($data['password']);
                        } else {
                            $validator->errors()->add('password', __('validation.confirmed', [
                                'attribute' => 'senha',
                            ]));
                        };
                    } else {
                        $validator->errors()->add('password', __('validation.max.string', [
                            'attribute' => 'senha',
                            'max' => 100,
                        ]));
                    };
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'senha',
                        'min' => 8,
                    ]));
                };
            };

            if (count($validator->errors()) > 0) {
                return redirect()->route('users.edit', ['user' => $id])->withErrors($validator);
            }

            $user->save();
        };

        return redirect()->route('users.index');
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

        if($loggedId !== intval($id)){
            $user = User::find($id);
            $user->delete();
        };

        return redirect()->route('users.index');
    }
}
