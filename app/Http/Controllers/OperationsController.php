<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Trip;

class OperationsController extends Controller
{
    public function create_city(Request $request)
    {
        // TODO: Add admin authorization.

        $validatedData = $request->validate([
            'city_name' => 'required|string|max:255',
            'city_order' => 'required|integer|unique:cities'
        ]);

        $city = City::create([
            'city_name' => $validatedData['city_name'],
            'city_order' => $validatedData['city_order']
        ]);

        return response()->json([
            'id' => $city->id,
            'city_name' => $city->city_name,
            'city_order' => $city->city_order
        ]);
    }

    public function get_city(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $cities = City::where('id', $id)->orderBy('order', 'ASC')->get();
        } else {
            $cities = City::orderBy('order', 'ASC')->get();
        }

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function update_city(Request $request)
    {
        $id = $request->id;
        if (!$id) {
            return response()->json([
                'message' => 'missing city id'
            ], 417);
        }

        $city = City::find($id);
        if (!$city) {
            return response()->json([
                'message' => 'city with ' . $id . 'not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'city_name' => 'nullable|string',
            'city_order' => 'nullable|integer'
        ]);

        if ($request->get('city_name') != null) {
            $city->city_name = $request->get('city_name');
        }

        if ($request->get('city_order') != null) {
            $city->city_order = $request->get('city_order');
        }

        $city->save();

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $city
        ], 200);
    }

    public function swap_cities_orders(Request $request, $id1, $id2)
    {
        $city_1 = City::find($id1);
        if (!$city_1) {
            return response()->join([
                'message' => 'City with ' . $id1 . ' not found'
            ], 404);
        }

        $city_2 = City::find($id2);
        if (!$city_2) {
            return response()->join([
                'message' => 'City with ' . $id2 . ' not found'
            ], 404);
        }

        $tmp_swap = $city_1->city_order;

        $city_1->city_order = $city_2->city_order;

        // Adding negative temp negative value to be able to swap unique values.
        $city_2->city_order = -1000;
        $city_2->save();

        $city_1->save();

        $city_2->city_order = $tmp_swap;
        $city_2->save();

        return response()->json([
            'message' => 'Swapped successfully',
            'city_1' => $city_1,
            'city_2' => $city_2
        ]);
    }

    public function create_trip(Request $request)
    {
        // TODO: Add admin authorization


        $validatedData = $request->validate([
            'trip_name' => 'required|string|unique:trips',
            'from_city' => 'required|string',
            'to_city' => 'required|string'
        ]);

        $from_city = City::where('city_name', $validatedData['from_city'])->first();

        if (!$from_city) {
            return response()->json([
                'message' => 'city ' . $validatedData['from_city'] . ' not found'
            ], 404);
        }

        $to_city = City::where('city_name', $validatedData['to_city'])->first();
        if (!$to_city) {
            return response()->json([
                'message' => 'city ' . $validatedData['to_city'] . ' not found'
            ], 404);
        }

        if ($from_city->id == $to_city->id) {
            return response()->json([
                'message' => 'cannot create trip from & to the same city.'
            ], 417);
        }

        if ($from_city->city_order > $to_city->city_order) {
            return response()->json([
                'message' => 'Invalid cities order, from city ' . $from_city->city_name . ' cannot be before to city ' . $to_city->city_name
            ], 417);
        }

        $trip = Trip::create([
            'trip_name' => $validatedData['trip_name'],
            'from_city_id' => $from_city->id,
            'to_city_id' => $to_city->id  
        ]);

        return response()->json([
            'message' => "Created trip successfully.",
            'trip' => [ 
                'trip_name' => $trip->trip_name,
                'from_city_id' => $trip->from_city->id,
                'from_city_name' => $trip->from_city->city_name,
                'to_city_id' => $trip->to_city->id,
                'to_city_name' => $trip->to_city->city_name
            ]
        ], 200);
    }
}
