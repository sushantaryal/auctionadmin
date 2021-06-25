<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Events\BidPlaced;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\BidController
 */
class BidControllerTest extends TestCase
{
    /**
     * @test
     */
    public function store_behaves_as_expected()
    {
        Event::fake();

        $response = $this->post(route('bid.store'));

        Event::assertDispatched(BidPlaced::class);
    }
}
