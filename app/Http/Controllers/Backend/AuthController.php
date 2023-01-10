<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Exception;
use Hash;

class AuthController extends Controller
{
    static $view = 'backend.edit_password';

    public function index(Request $request)
    {
        return view(self::$view.'.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [            
            'old_password'      => ['required', 'string'],
            'newly_password'      => ['required', 'string', 'confirmed'],
        ];

        $messages = [];

        $attributes = [
            'old_password'    => __('password'),
            'newly_password'    => __('newly').__('password'),
        ];

        $validatedData = $request->validate($rules, $messages, $attributes);

        try{
            if (!Hash::check($validatedData['old_password'], auth()->user()->password)) {
                throw new Exception(__('password_error'));
            }

            User::findOrFail(auth()->user()->id)->update(array_merge($validatedData, ['password' => bcrypt($request->newly_password)]));
            return response()->json(['message' => __('edit').__('success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
