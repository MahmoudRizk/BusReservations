<?php

namespace App\Domain;

function check_overlap(TripSet $interval_1, TripSet $interval_2)
{
    $tmp_swap = new TripSet($interval_1->x, $interval_1->y);

    if ($interval_2->x < $interval_1->x) {
        // swap
        $interval_1 = new TripSet($interval_2->x, $interval_2->y);
        $interval_2 = new TripSet($tmp_swap->x, $tmp_swap->y);
    }

    if ($interval_1->x == $interval_2->x) {
        return true;
    }

    if ($interval_1->y >= $interval_2->y || $interval_1->y > $interval_2->x) {
        return true;
    }

    return false;
}

class TripValidation
{
    static public function available_seats_number(TripSet $trip, array $reservations, int $max_seats)
    {
        if ($trip->x >= $trip->y) {
            return 0;
        }

        foreach ($reservations as $it) {
            if (!$max_seats) {
                return 0;
            }

            $is_overlapped = check_overlap($it, $trip);
            if ($is_overlapped) {
                $max_seats -= 1;
            }
        }

        return max($max_seats, 0);
    }
}
