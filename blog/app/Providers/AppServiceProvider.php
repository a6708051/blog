<?php

namespace App\Providers;

use App\Http\Models;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $data = Models\Article_cat::where('status', '>', 0)->orderBy('sort_id')->get();
        $category = [];
        foreach ($data as $dv) {
            $category[$dv['id']] = $dv;
        }
        view()->share('category', $category);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
