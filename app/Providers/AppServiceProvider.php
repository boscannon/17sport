<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;
use App\Models\Language;

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
		if(env('SERVICE_HTTPS', 0)) \URL::forceScheme('https');
        $menuData = config('menu');

        View::composer(
            'backend/partials/sidebar', function($view) use ($menuData){
                $permissions = auth()->user()->getAllPermissions()->pluck('name')->all();
                $view->with(['menuData' => $menuData, 'permissions' => $permissions]);
            }
        );
        View::composer(
            '*', function($view) use ($menuData){

                $titleData = '';
                $subTitleData = '';
                $routeNameData = '';
                $routeIdData = '';
                $permissionsData = '';
                foreach($menuData as $value){
                    if(request()->is('backend/'.$value['active']) || request()->is('backend/'.$value['active'].'/*')){
                        $value['title'] = __("backend.menu.{$value['title']}");
                        $titleData .= $value['title']; 
                        $subTitleData = $value['title']; 
                        $routeNameData = $value['name'] ?? ''; 
                        $routeIdData = $value['routeId'] ?? '';
                        $permissionsData = $value['permissions'] ?? '';
                    }
                    if(isset($value['child'])){
                        foreach($value['child'] as $sub_value)
                        {
                            if(request()->is('backend/'.$sub_value['active']) || request()->is('backend/'.$sub_value['active'].'/*')){
                                $sub_value['title'] = __("backend.menu.{$sub_value['title']}");
                                $titleData .= '/'.$sub_value['title']; 
                                $subTitleData = $sub_value['title']; 
                                $routeNameData = $sub_value['name']; 
                                $routeIdData = $sub_value['routeId']; 
                                $permissionsData = $sub_value['permissions']; 
                            }                    
                        }
                    }
                }

                $view->with([
                    'titleData' => $titleData,
                    'subTitleData' => $subTitleData,
                    'routeNameData' => $routeNameData,
                    'routeIdData' => $routeIdData,
                    'permissionsData' => $permissionsData,
                    'languageData' => Language::all(),
                ]);
            }
        );

        Paginator::useBootstrap();
    }
}
