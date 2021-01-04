<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loggedId = intval(Auth::id());

        $user = User::find($loggedId);

        if ($user) {
            return view('admin.profile.index', [
                'user' => $user
            ]);
        }

        return redirect()->route('admin');
    }

    public function save(Request $request)
    {
        $loggedId = intval(Auth::id());

        $user = User::find($loggedId);

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
                    if (strlen($data['password']) <= 100) {
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
                return redirect()->route('profile', ['user' => $loggedId])->withErrors($validator);
            }

            $user->save();

            return redirect()->route('profile')->with('warning', 'Informações alteradas com sucesso');
        }

        return redirect()->route('profile');
    }
}
