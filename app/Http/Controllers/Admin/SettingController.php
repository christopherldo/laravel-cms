<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = [];

        $data = Setting::get();

        foreach ($data as $item) {
            $settings[$item['name']] = $item['content'];
        };

        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->only([
            'title',
            'subtitle',
            'email',
            'bgcolor',
            'textcolor'
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->route('settings')->withErrors($validator);
        };

        foreach($data as $item => $value){
            Setting::where('name', $item)->update([
                'content' => $value
            ]);
        };

        return redirect()->route('settings')->with(
            'warning', 'Informações alteradas com sucesso!'
        );
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email' => ['string', 'email', 'max:100'],
            'bgcolor' => ['string', 'max:7', 'regex:/#[a-zA-Z0-9]{6}/i'],
            'textcolor' => ['string', 'max:7', 'regex:/#[a-zA-Z0-9]{6}/i']
        ]);
    }
}
