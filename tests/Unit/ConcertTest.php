<?php

namespace Tests\Unit;

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make([
          'date' => Carbon::parse('2017-12-01 8:00pm', 'America/Toronto')
        ]);

        $this->assertEquals('December 1, 2017', $concert->formatted_date);
    }

    /**
     * @test
     */
    public function can_get_formatted_start_time(){
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2017-12-01 17:00:00')
        ]);

        $this->assertEquals( '5:00pm' , $concert->formatted_start_time);
    }

    /**
     * @test
     */
    public function can_get_ticket_price_in_dollars() {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 3450
        ]);

        $this->assertEquals( '34.50' , $concert->ticket_price_in_dollars);
    }

    /**
     * @test
     */
    public function concerts_with_apublished_at_date_are_published(){
        $publishedConcertA = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedConcertB = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $unpublishedConcert = factory(Concert::class)->create(['published_at' => null]);

        $publishedConcerts = Concert::published()->get();
        $this->assertTrue($publishedConcerts->contains($publishedConcertA));
        $this->assertTrue($publishedConcerts->contains($publishedConcertB));
        $this->assertFalse($publishedConcerts->contains($unpublishedConcert));
    }
}
