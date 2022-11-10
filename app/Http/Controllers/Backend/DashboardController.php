<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as crudModel;
use DataTables;
use Exception;

class DashboardController extends Controller
{
    public function __construct() {
        $this->name = 'dashboard';
        $this->view = 'backend.'.$this->name;
    }

    public function index(Request $request)
    {
        $permissions = auth()->user()->getAllPermissions()->pluck('name')->filter(function ($value, $key) {
            return strpos($value, 'read') !== false;
        });
        if($permissions->search('read dashboard') !== false || auth()->user()->super_admin){
            return redirect()->route("backend.users.index");
            return view($this->view.'.index');
        }
        
        if(!$permissions->first()){
            abort(403);
        }

        $name = explode(' ', $permissions->first())[1];
        return redirect()->route("backend.$name.index");
    }
}
