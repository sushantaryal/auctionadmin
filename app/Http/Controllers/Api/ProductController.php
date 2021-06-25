<?php

namespace App\Http\Controllers\Api;

use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * @return \App\Http\Resources\Api\ProductCollection
     */
    public function index()
    {
        $current_products = Product::with(['category', 'bookmarks', 'latestBid.user', 'photos'])->where('expire_at', '>', now())->orderBy('expire_at')->get();
        $past_products = Product::with(['category', 'bookmarks', 'latestBid.user', 'photos'])->where('expire_at', '<', now())->orderBy('expire_at', 'desc')->get();

        $products = $current_products->merge($past_products)->all();

        $total = count($products);
        $per_page = 60;
        $current_page = request('page') ?? 1;
        $starting_point = ($current_page * $per_page) - $per_page;
        $products = array_slice($products, $starting_point, $per_page, true);

        $products = new LengthAwarePaginator($products, $total, $per_page, $current_page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return ProductResource::collection($products);
    }

    /**
     * @param \App\Models\Product $product
     * @return \App\Http\Resources\Api\ProductResource
     */
    public function show(Product $product)
    {
        $product->load(['category', 'bookmarks', 'latestBid.user', 'photos']);

        $bids = Bid::with('user')->where('product_id', $product->id)->orderBy('bid_at', 'desc')->limit(10)->get();
        
        return (new ProductResource($product))
                ->additional([
                    'bids' => $bids
                ]);
    }

    public function search(Request $request)
    {
        $products = Product::with(['category', 'bookmarks', 'latestBid.user', 'photos']);

        if ($request->filled('q')) {
            $products->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $products->whereHas('category', function ($query) use($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $products = $products->orderBy('expire_at')->paginate(60);

        return ProductResource::collection($products);
    }

    /**
     * Return all bids for a product
     *
     * @param Product $product
     * @return void
     */
    public function bids(Product $product)
    {
        $bids = Bid::with('user')
        ->select(DB::raw('user_id, MAX(id) as max_id, MAX(price) as max_price, COUNT(user_id) as total_bids, MAX(country) as country, MAX(bid_at) as bid_at'))
        ->where('product_id', $product->id)
        ->groupBy('user_id')
        ->orderBy('max_price', 'desc')
        ->paginate(10);

        return $bids;
    }
}
