<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Exception;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Image;

class AvatarController extends Controller
{
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
            'avatar' => ['required', 'string'],                   
        ];

        $messages = [];

        $attributes = [
            'avatar' => __('image'),        
        ];

        $validatedData = $request->validate($rules, $messages, $attributes);
        
        try{
            $data = User::findOrFail(auth()->user()->id);
            $data->update($validatedData);

            return response()->json(['message' => __('upload').__('success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }  
}
