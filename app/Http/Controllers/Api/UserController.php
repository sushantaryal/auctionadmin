<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\ProductResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * User Dashboard
     *
     * @return void
     */
    public function index()
    {
        $user = auth()->user();
        $bidsCount = $user->bids()->distinct('product_id')->count();
        $bookmarksCount = $user->bookmarks()->count();
        $wonAuctionsCount = $user->bids()
        ->distinct('product_id')
        ->where('expire_at', '<', now())
        ->whereHas('latestBid', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->count();

        $ordersCount = $user->orders()->count();

        return response()->json(compact('bidsCount', 'bookmarksCount', 'wonAuctionsCount', 'ordersCount'));
    }

    /**
     * Current user
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {
        JsonResource::withoutWrapping();
        return new UserResource($request->user());
    }

    /**
     * Update user profile
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $input = $request->all();

        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => [
                'nullable',
                'mimes:jpg,jpeg,png'
            ]
        ])->validateWithBag('updateProfileInformation');

        $fileName = $user->image ?? null;
        if ($request->hasFile('image')) {

            if (Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $file = $request->file('image');
            $fileName = $file->storeAs('users', $file->getClientOriginalName());
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
                $user->forceFill([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'email_verified_at' => null,
                    'image' => $fileName,
                ])->save();
        
                $user->sendEmailVerificationNotification();
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'image' => $fileName,
            ])->save();
        }

        JsonResource::withoutWrapping();
        return new UserResource($user);
    }

    /**
     * Get bidding History
     *
     * @return void
     */
    public function getBiddingHistory()
    {
        $products = Product::with(['bids' => function ($query) {
            $query->where('user_id', auth()->id())->orderBy('pivot_price', 'desc');
        }])
        ->withCount(['bids' => function ($query) {
            $query->where('user_id', auth()->id());
        }])
        ->whereHas('bids', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->paginate(20);

        return $products;
    }

    /**
     * Get won auctions
     *
     * @return void
     */
    public function getWonAuctions()
    {
        $products = Product::with('order')->where('expire_at', '<', now())
        ->whereHas('latestBid', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->whereHas('bids', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->paginate(20);

        return ProductResource::collection($products);
    }

    /**
     * Get bookarks
     *
     * @return void
     */
    public function getBookmarks()
    {
        $products = auth()->user()->bookmarks()->paginate(10);

        return ProductResource::collection($products);
    }
}
