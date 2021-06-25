<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertViewIs('product.index');
        $response->assertViewHas('products');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('product.create'));

        $response->assertOk();
        $response->assertViewIs('product.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\ProductController::class,
            'store',
            \App\Http\Requests\Admin\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $category = Category::factory()->create();
        $name = $this->faker->name;
        $slug = $this->faker->slug;
        $image = $this->faker->word;
        $initial_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $expire_at = $this->faker->dateTime();
        $description = $this->faker->text;

        $response = $this->post(route('product.store'), [
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'image' => $image,
            'initial_price' => $initial_price,
            'price' => $price,
            'expire_at' => $expire_at,
            'description' => $description,
        ]);

        $products = Product::query()
            ->where('category_id', $category->id)
            ->where('name', $name)
            ->where('slug', $slug)
            ->where('image', $image)
            ->where('initial_price', $initial_price)
            ->where('price', $price)
            ->where('expire_at', $expire_at)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $products);
        $product = $products->first();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertViewIs('product.show');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.edit', $product));

        $response->assertOk();
        $response->assertViewIs('product.edit');
        $response->assertViewHas('product');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\ProductController::class,
            'update',
            \App\Http\Requests\Admin\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $name = $this->faker->name;
        $slug = $this->faker->slug;
        $image = $this->faker->word;
        $initial_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $expire_at = $this->faker->dateTime();
        $description = $this->faker->text;

        $response = $this->put(route('product.update', $product), [
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'image' => $image,
            'initial_price' => $initial_price,
            'price' => $price,
            'expire_at' => $expire_at,
            'description' => $description,
        ]);

        $product->refresh();

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('product.id', $product->id);

        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals($name, $product->name);
        $this->assertEquals($slug, $product->slug);
        $this->assertEquals($image, $product->image);
        $this->assertEquals($initial_price, $product->initial_price);
        $this->assertEquals($price, $product->price);
        $this->assertEquals($expire_at, $product->expire_at);
        $this->assertEquals($description, $product->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertRedirect(route('product.index'));

        $this->assertDeleted($product);
    }
}
