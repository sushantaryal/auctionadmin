<?php

namespace App\Http\Controllers\Api;

use App\Models\Bid;
use App\Models\Product;
use App\Events\BidPlaced;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;

class BidController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        // Current user
        $user = auth()->user();

        // User bid
        $newPrice = $request->bidPrice;

        if ($product->expire_at < now()) {
            abort(403, 'Auction is closed');
        }

        // Min bid allowed
        $minBid = $product->price + $product->min_increment;
        $minBid = number_format((float)$minBid, 2, '.', '');

        if ($newPrice < $minBid) {
            abort(403, 'Your bid must be greater than ' . $minBid);
        }
        if ($newPrice > $product->closing_price) {
            abort(403, 'Your bid must be equal to or lower than ' . $product->closing_price);
        }

        if ($user->bid_credit < $product->bid_credit) {
            abort(403, 'You do not have enough bid credit. Please purchase credit to bid on this item.');
        }

        $product->price = $newPrice;
        $product->save();

        $bid = new Bid;
        $bid->bid_at = now()->format('Y-m-d H:i:s.u');
        $bid->price = $newPrice;
        $bid->ip_address = $request->ip();
        $bid->country = geoip($request->ip())['country'];
        $bid->user()->associate($user);
        $bid->product()->associate($product);
        
        if ($bid->save()) {
            $user->bid_credit -= $product->bid_credit;
            $user->save();

            $product->load(['category', 'bookmarks', 'latestBid.user', 'photos']);
            $product = new ProductResource($product);
            BidPlaced::dispatch($user, $product);
            
            return response('Bid has been added.');
        } else {
            abort(500, 'Sorry!! We cannot place a bid at the moment.');
        }
    }
}
