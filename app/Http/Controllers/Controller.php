<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dealfile($upload, $returnKey = 'path', $delete = null, $deleteKey = 'path')
    {
        $fileUpload = function ($value) use ($returnKey) {
            if($value = json_decode($value, true)){
                $extension = pathinfo($value['name'], PATHINFO_EXTENSION);
                $path = config('app.upload').'/'.Str::random(20).'_'.time().'.'.$extension;
                if(in_array($extension, ['png', 'jpg', 'jpeg'])){
                    Image::make($value['data'])->save($path);
                }else{
                    file_put_contents($path, base64_decode($value['data']));
                }
                return [ 
                    $returnKey => $path,
                    'file_name' => $value['name']
                ];
            }
        };

        $fileData = [];
        if(isset($upload)){
            if($upload instanceof \Illuminate\Database\Eloquent\Collection || is_array($upload)){
                foreach($upload as $value){
                    if($tmp = $fileUpload($value)){
                        $fileData[] = $tmp;
                    }
                }
            }else{
                if($tmp = $fileUpload($upload)){
                    $fileData = $tmp;
                }            
            }
        }

        if(isset($delete)){
            if($delete instanceof \Illuminate\Database\Eloquent\Collection || is_array($delete)){
                foreach($delete as $value){
                    if(is_file($value[$deleteKey])){
                        unlink($value[$deleteKey]);
                    }
                }
            }else{
                if(is_file($delete[$deleteKey])){
                    unlink($delete[$deleteKey]);
                }          
            }
        }

        return $fileData;
    }
}
