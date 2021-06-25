<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Http\Resources\Api\ProductResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('product')->latest()->paginate(20);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::with('order', 'latestBid.user')->find($id);

        if ($product->order || $product->latestBid->user->id != $user->id) {
            abort(403, 'Order already placed.');
        }

        $order = new Order;
        $order->status = 1;
        $order->user()->associate($user);
        $order->product()->associate($product);
        $order->save();

        return new ProductResource($product->fresh()->load('order'));

    }
}
