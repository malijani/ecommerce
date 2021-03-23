<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\ProvinceCity;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Return the cities by province(parent) id
     * @param Request $request
     * @return
     */
    public function cities(Request $request)
    {
        $request->validate([
            'title'=>['required','exists:province_cities,title'],
        ]);
        $province = ProvinceCity::withoutTrashed()->where('title', $request->input('title'))->where('parent', 0)->firstOrFail();
        return response()->json($province->children);
    }
}
