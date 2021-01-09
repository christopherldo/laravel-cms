<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $frontMenu = [
            '/' => 'Home'
        ];

        $pages = Page::all();

        $adminUsers = User::where('admin', 1)->get();

        $adminUsersId = [];

        foreach($adminUsers as $admin){
            array_push($adminUsersId, $admin->id);
        };

        foreach($pages as $page){
            if(in_array($page->created_by, $adminUsersId)){
                $frontMenu[$page['slug']] = $page['title'];
            };
        };

        View::share('front_menu', $frontMenu);

        $config = [];

        $settings = Setting::all();

        foreach($settings as $setting){
            $config[$setting['name']] = $setting['content'];
        };

        View::share('front_config', $config);
    }
}
