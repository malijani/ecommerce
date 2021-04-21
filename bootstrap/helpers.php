<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

/**
 * Image uploader
 * @param Request
 * @param string
 * @return mixed
 */
function imageUploader(Request $request, $field, $dir, $wsize = null, $hsize = null, $watermark = false, $watermark_path = ''): ?string
{
    if ($request->hasFile($field)) {
        $file = $request->file($field);
        $name = Str::random(20) . '.' . $file->extension() ?? 'png';
        $path = 'storage/files/shares/' . $dir;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $pic = $path . '/' . $name;
        // CONVERT IMAGE TO 300x300 PNG WITH WATERMARK
        $manager = new ImageManager(['driver' => 'imagick']);
        $handler = $manager->make($file->path());
        if (!is_null($wsize) || !is_null($hsize)) {
            $handler->resize($wsize, $hsize, function ($c) {
//                $c->aspectRatio();
                $c->upsize();
            });
        }

        if ($watermark) {
            $handler->insert(env('WATERMARK_PATH', 'images/watermark/watermark-80.png' ?? $watermark_path), 'bottom-right', 5, 5);
        }

        $handler->encode('png');
        $handler->save($pic);
        return $pic;
    } else {
        return null;
    }
}


/**
 * Get the value of user rate to a model
 * @param object $model
 * @return int
 */
function getUserRating(object $model): int
{
    $user = Auth::user();
    if (!is_null($user) && $user->isRated($model)) {
        $rate = $user->getRatingValue($model);
    } else {
        $rate = 0;
    }
    return $rate;
}

/**
 * Return a specific unique string based on model and column
 * @param object $model
 * @param string $column
 * @param int $length
 * @return string
 */
function generateUniqueString(object $model, string $column, int $length = 11): string
{
    $model = new $model;
    $uuid = '#'.Str::random($length);

    while ($model->where($column, '=', $uuid)->count() > 0) {
        $uuid = '#'.Str::random($length);
    }

    return $uuid;
}
