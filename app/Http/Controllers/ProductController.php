<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::withCount('bids')->latest();
            return DataTables::eloquent($products)
                ->addIndexColumn()
                ->addColumn('act_expire', function ($product) {
                    $expirevalue = $product->expire_at->format('Y-m-d h:i:s A');

                    if ($product->expire_at > now()) {
                        $expirevalue .= '<span class="ml-3 btn btn-xs btn-success">Open</span>';
                    } else {
                        $expirevalue .= '<span class="ml-3 btn btn-xs btn-danger">Closed</span>';
                    }

                    return $expirevalue;
                })
                ->addColumn('action', function ($product) {
                    return '<form action="' . route('products.destroy', $product->id) . '" method="post" delete-confirm="Are you sure you want delete this product?">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        <a class="btn btn-success btn-sm" href="' . route('products.replicate', $product->id) . '"><i class="fas fa-clone"></i> Replicate</a>
                        <a class="btn btn-info btn-sm" href="' . route('products.edit', $product->id) . '"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>';
                })
                ->rawColumns(['act_expire', 'action'])
                ->toJson();
        }

        return view('products.index');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->except(['_token', 'image']);
        $data['price'] = $data['initial_price'];
        $data['starts_at'] = now();

        $product = Product::create($data);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $photo = new Photo;
                $photo->path = $file->storeAs('products', $this->generateFileName($file->extension()));
                $product->photos()->save($photo);
            }
        }

        return back()->with('success', 'Product has been added successfully.');
    }

    /**
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function replicate(Product $product)
    {
        $today = now()->toDateTimeString();

        $newProduct = $product->replicate();

        $parent_id = $product->parent_id ? $product->parent_id : $product->id;
        $newProduct->parent()->associate($parent_id);
        $newProduct->price = $newProduct->initial_price;
        $newProduct->starts_at = $today;
        $newProduct->expire_at = now()->addDay()->toDateTimeString();
        $newProduct->created_at = $today;
        $newProduct->updated_at = $today;

        $newProduct->save();

        return redirect()->route('products.edit', $newProduct->id)->with('success', 'Product replicated successfully. Please make the necessary changes.');
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->except(['_token', 'image']);

        $product->fill($data);

        $product->save();

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $photo = new Photo;
                $photo->path = $file->storeAs('products', $this->generateFileName($file->extension()));
                $product->parent ? $product->parent->photos()->save($photo) : $product->photos()->save($photo);
                // $product->photos()->save($photo);
            }
        }

        return back()->with('success', 'Product has been updated successfully.');
    }

    /**
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product has been deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroyPhoto(Photo $photo)
    {
        $photo->delete();

        $message = 'Photo has been deleted successfully.';

        if (request()->ajax()) {
            return response(['message' => $message]);
        }

        return back()->with('success', $message);
    }

    /**
     * Generate unique filename
     *
     * @param $extension
     * @return String
     */
    public function generateFileName($extension)
    {
        $filename = Uuid::uuid4() . '.' . $extension;
        if (Storage::exists('products/' . $filename)) {
            $this->generateFileName($extension);
        }

        return $filename;
    }
}
