<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Trip;
use App\Models\City;
use App\Domain\TripSet;
use App\Domain\TripValidation;
use App\Services\ServiceResponse;

class ReservationService
{
    private string $user_id;
    private int $trip_id;
    private int $from_city_id;
    private int $to_city_id;

    // TODO: How can we pass arguments to the service constructor.

    // public function __construct()
    // {
    //     $this->user_id = $user_id;
    //     $this->trip_id = $trip_id;
    //     $this->from_city_id = $from_city_id;
    //     $this->to_city_id = $to_city_id;
    // }

    public function createReservation(string $user_id, int $trip_id, int $from_city_id, int $to_city_id)
    {

        $trip = Trip::find($trip_id);
        if (!$trip) {
            return new ServiceResponse(false, "TripNotFound", "trip_id not found");
        }

        $reservation = new Reservation();
        $reservation->user_id = $user_id;
        $reservation->trip_id = $trip_id;
        $reservation->from_city_id = $from_city_id;
        $reservation->to_city_id = $to_city_id;

        $available_seats = check_available_seats($trip, $reservation);

        if ($available_seats <= 0) {
            return new ServiceResponse(false, "NoAvailableSeats", "No Avaialble Seats");
        }

        $reservation->save();

        $data = [
            "reservation" => $reservation,
            "avaialble_seats" => $available_seats - 1
        ];
        return new ServiceResponse(true, "",  "Reservation created successfully", $data);
    }
}



function check_available_seats(Trip $trip, Reservation $reservation)
{
    $trip_reservations = Reservation::where('trip_id', $trip->id)->get();
    error_log($trip_reservations);
    $max_seats_number = $trip->max_seats_number;

    $mapped_trip_reservations = array();
    foreach ($trip_reservations as $it) {
        $res = convert_reservation_to_trip_set($it);
        array_push($mapped_trip_reservations, $res);
    }

    $mapped_reservation_request = convert_reservation_to_trip_set($reservation);

    $available_number_of_seats = TripValidation::available_seats_number($mapped_reservation_request, $mapped_trip_reservations, $max_seats_number);

    return $available_number_of_seats;
}

function convert_reservation_to_trip_set(Reservation $reservation)
{
    $from_city = City::find($reservation->from_city_id);
    $to_city = City::find($reservation->to_city_id);

    return new TripSet($from_city->city_order, $to_city->city_order);
}
