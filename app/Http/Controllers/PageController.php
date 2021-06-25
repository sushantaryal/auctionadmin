<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pages = Page::latest();
            return DataTables::eloquent($pages)
                ->addIndexColumn()
                ->addColumn('act_published', function ($page) {
                    if ($page->published) {
                        return '<a href="' . route('pages.published', $page->id) . '" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Yes</a>';
                    }
                    return '<a href="' . route('pages.published', $page->id) . '" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> No</a>';
                })
                ->addColumn('action', function ($page) {
                    return '<form action="' . route('pages.destroy', $page->id) . '" method="post" delete-confirm="Are you sure you want delete this page?">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        <a class="btn btn-info btn-sm" href="' . route('pages.edit', $page->id) . '"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>';
                })
                ->rawColumns(['act_published', 'action'])
                ->toJson();
        }
        return view('pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $request->merge([
            'published' => $request->has('published') ? 1 : 0
        ]);

        $page = new Page($request->all());
        $page->save();

        return back()->with('success', 'Page has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $request->merge([
            'published' => $request->has('published') ? 1 : 0
        ]);

        $page->fill($request->all());
        $page->save();

        return back()->with('success', 'Page has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return back()->with('success', 'Page has been deleted successfully.');
    }

    /**
     * Toggle published (boolean) attribute.
     *
     * @param \App\Models\Page $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function published(Page $page)
    {
        $page->published = !$page->published;
        $page->save();

        return back()->with('success', 'A page has been updated successfully.');
    }
}
