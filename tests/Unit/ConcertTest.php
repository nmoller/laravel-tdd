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
        $concert = factory(Concert::class)->create([
          'date' => Carbon::parse('2017-12-01 8:00pm', 'America/Toronto')
        ]);

        $date = $concert->formatted_date;

        $this->assertEquals('December 1, 2017', $date);
    }
}
