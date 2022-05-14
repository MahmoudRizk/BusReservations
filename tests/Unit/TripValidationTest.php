<?php

namespace Tests\Unit;

use App\Domain\TripSet;
use App\Domain\TripValidation;

use PHPUnit\Framework\TestCase;

function get_expected(int $max_seats, int $intersections)
{
    return max(0, $max_seats - $intersections);
}

class TripValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $max_seats = 12;

        $reservations = [
            new TripSet(1, 4),
            new TripSet(1, 4),
            new TripSet(1, 2),
            new TripSet(1, 3),
            new TripSet(2, 3),
            new TripSet(2, 3),
            new TripSet(2, 3),
            new TripSet(2, 4),
            new TripSet(4, 8),
            new TripSet(5, 8)
        ];

        $test_cases = [
            [new TripSet(1, 8), get_expected($max_seats, 10)],
            [new TripSet(1, 3), get_expected($max_seats, 8)],
            [new TripSet(3, 4), get_expected($max_seats, 3)],
            [new TripSet(4, 8), get_expected($max_seats, 2)],
            [new TripSet(2, 3), get_expected($max_seats, 7)],
            [new TripSet(6, 7), get_expected($max_seats, 2)],
            [new TripSet(7, 8), get_expected($max_seats, 2)],

            // Invalid reservation will always be zero
            [new TripSet(1, 1), 0],
            [new TripSet(5, 5), 0],
            [new TripSet(8, 1), 0],
        ];

        foreach ($test_cases as $it) {
            $test_case = $it[0];
            $expected = $it[1];

            $res = TripValidation::available_seats_number($test_case, $reservations, $max_seats);
            $this->assertEquals($res, $expected);
        }
    }
}
