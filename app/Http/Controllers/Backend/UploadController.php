<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Image;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [            
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif'],
            'pdf' => ['nullable', 'file', 'mimes:pdf'],
            
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif'],
            'pdfs' => ['nullable', 'array'],
            'pdfs.*' => ['nullable', 'file', 'mimes:pdf'],
            'home_carousel' => ['nullable', 'array'],
            'home_carousel.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif'],                           
        ];

        $messages = [];

        $attributes = [
            'image' => __('image'),
            'pdf' => __('pdf'),
            'images' => __('image'),
            'pdfs' => __('pdf'),   
            'home_carousel' => __('image'),         
        ];

        $validatedData = $request->validate($rules, $messages, $attributes);
        
        try{
            foreach(['image', 'pdf', 'images', 'pdfs'] as $type){
                if (isset($validatedData[$type])) {
                    $file = is_array($validatedData[$type]) ? Arr::first($validatedData[$type]) : $validatedData[$type];
                    $path = config('app.upload').'/'.Str::random(20).time().'.'.$file->getClientOriginalExtension();
                    Image::make($file->getRealPath())->save($path);
                    $data = [
                        'name' => $file->getClientOriginalName(),
                        'path' => '/'.$path
                    ];
                    return response()->json($data);
                }     
            }      
            return response()->json([]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
