<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Show searching page
     * @return View
     */
    public function index(): View
    {
        return view('front-v1.search.index');
    }

    /**
     * Show search result
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        return view('front-v1.search.index');
        dd($request->all());

    }
}
