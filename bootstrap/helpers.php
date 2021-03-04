<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

/**
 * Image uploader
 * @param Request
 * @param string
 * @return mixed
 */
function imageUploader(Request $request, $field, $dir, $wsize=null, $hsize=null, $watermark=false, $watermark_path='') : ?string
{
    if ($request->hasFile($field)){
        $file = $request->file($field);
        $name = Str::random(20) . '.' . $file->extension()??'png';
        $path = 'storage/files/shares/'.$dir;
        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }
        $pic = $path .'/'. $name;
        // CONVERT IMAGE TO 300x300 PNG WITH WATERMARK
        $manager = new ImageManager(['driver'=>'imagick']);
        $handler = $manager ->make($file->path());
        if(!is_null($wsize) || !is_null($hsize)){
            $handler->resize($wsize, $hsize, function($c){
//                $c->aspectRatio();
                $c->upsize();
            });
        }

        if($watermark){
            $handler->insert(env('WATERMARK_PATH', 'images/watermark/watermark-80.png' ?? $watermark_path ), 'bottom-right', 5, 5);
        }
        $handler->encode('png');
        $handler->save($pic);
        return $pic;
    } else {
        return null;
    }
}
