<?php

namespace App\GraphQL\Mutations;


use App\Services\ReservationService;
use ErrorException;

final class ReservationMutator
{

    protected ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = $args["user_id"];
        $trip_id = $args["trip_id"];
        $from_city_id = $args["from_city_id"];
        $to_city_id = $args["to_city_id"];

        $res = $this->reservationService->createReservation($user_id, $trip_id, $from_city_id, $to_city_id);

        if ($res->success == true) {
            $data = $res->data["reservation"];
            return [
                "id" => $data->id,
                "trip_id" => $data->trip_id,
                "from_city_id" => $data->from_city_id,
                "to_city_id" => $data->to_city_id
            ];
        }

        throw new ErrorException('Reservation mutation error');
    }
}
