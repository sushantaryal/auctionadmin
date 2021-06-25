<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'slug',
        'initial_price',
        'price',
        'closing_price',
        'auto_increment',
        'min_increment',
        'bid_credit',
        'starts_at',
        'expire_at',
        'description',
        'features',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['updated', 'is_bookmarked'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'parent_id' => 'integer',
        'initial_price' => 'float',
        'price' => 'float',
        'closing_price' => 'float',
        'auto_increment' => 'boolean',
        'min_increment' => 'float',
        'bid_credit' => 'integer',
        'starts_at' => 'datetime',
        'expire_at' => 'datetime',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($product) {
            $product->photos()->each(function ($photo) {
                $photo->delete();
            });
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    /**
     * Model has many bids
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bids()
    {
        return $this->belongsToMany(User::class, 'bids', 'product_id', 'user_id')->withPivot('bid_at', 'price');
    }

    /**
     * Model belongs to parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    /**
     * Model hasMany to children
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    /**
     * Model belongs to category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Model has many bookmarks
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'product_id', 'user_id');
    }

    /**
     * Model has many photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get product latest bid
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestBid()
    {
        return $this->hasOne(Bid::class)->ofMany('price', 'max');
    }

    /**
     * Model belongs to order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Determine if the date is updated.
     *
     * @return bool
     */
    public function getUpdatedAttribute()
    {
        return false;
    }

    public function getIsBookmarkedAttribute()
    {
        if (!auth()->check()) {
            return false;
        }

        return !!$this->bookmarks->contains(auth()->id());
    }

    public function winners()
    {
        $winners = collect();

        if ($this->parent_id != 0) {
            $parent = $this->parent;
            $winners = $parent->children()
                ->where('expire_at', '<', now()->toDateTimeString())
                ->get()
                ->map(function ($item) {
                    $item->load('latestBid.user');
                    return $item->latestBid;
                });

            $parent->load('latestBid.user');
            $winners->push($parent->latestBid);

            $winners = $winners->filter(function ($item) {
                return !is_null($item);
            });
        }

        return $winners;
    }
}
