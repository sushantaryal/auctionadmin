<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::latest();
            return DataTables::eloquent($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return '<form action="' . route('categories.destroy', $category->id) . '" method="post" delete-confirm="Are you sure you want delete this category?">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        <a class="btn btn-info btn-sm" href="' . route('categories.edit', $category->id) . '"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('categories.index');
    }

    /**
     * @param \App\Http\Requests\Admin\CategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());

        return back()->with('success', 'Category has been created successfully.');
    }

    /**
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * @param \App\Http\Requests\Admin\CategoryUpdateRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return back()->with('success', 'Category has been updated successfully.');
    }

    /**
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category has been removed successfully.');
    }
}
