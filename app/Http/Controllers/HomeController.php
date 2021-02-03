<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware(['auth']);
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $categories = Category::withoutTrashed()
            ->where('parent_id', 0)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        return view('home', [
            'categories'=>$categories,
        ]);
    }
}
