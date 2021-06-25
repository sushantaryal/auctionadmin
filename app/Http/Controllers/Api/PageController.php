<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::where('published', true)->get();

        return PageResource::collection($pages);
    }

    /**
     * Display the specified resource.
     *
     * @param  $page
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        $page = Page::where('published', true)->where('slug', $page)->first();

        return new PageResource($page);
    }
}
