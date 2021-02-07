<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Card;

class CardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_reset() 
    {
        $this->get(route('reset'))
            ->assertStatus(200);
    }

    public function test_flip() {

        $card = new Card();
        $card->fill([
            'card_id' => 1,
            'flipped' => false,
            'found' => false,
        ]);

        $this->post(route('flip', $card))
            ->assertStatus(200);
    }
}
