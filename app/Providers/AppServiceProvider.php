<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
         Schema::defaultStringLength(191);
    
              view()->composer('layouts.monster', function($view)
    {
         $authId =Auth::id();
         $userPoint = User::where('id','!=',$authId) 
        ->whereHas('friends', function ($query) use ($authId){
                $query
                ->where('follower_id', $authId)
                ->where('accepted', 0);    
            })
        ->get(); 
        
        $view->with('userPoint', $userPoint);
       
    });
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
