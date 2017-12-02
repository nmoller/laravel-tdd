<?php

namespace Tests\Feature;

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConcertListingTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     *
     * @return void
     */
    public function user_can_view_a_concert_listing()
    {
        // Setup
            // Create a concert
        $concert = factory(Concert::class)->create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2017 8:00pm', 'America/Toronto'),
            'additional_information' => 'For tickets, call (555) 555-5555.'
        ]);

        // Act
            // View the concert listing
        $response = $this->get('/concerts/'.$concert->id);

        //Assert
            // See the concert details
        $response->assertSee('The Red Chord');
        $response->assertSee('with Animosity and Lethargy');
        $response->assertSee('For tickets, call (555) 555-5555.');
    }
}
