<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reservation;


class ReservationController extends Controller
{

    //function to get all reservations
    public function getAll()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    //function to create a reservation
    public function createReservation(Request $request)
    {
        //find user
        try{
            $user = User::find($request->userId);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found!'
            ], 404);
        }
        //find property
        try{
            $property = Property::find($request->propertyId);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Property not found!'
            ], 404);
        }
        $reservation = Reservation::create([
            'userId' => $user->id,
            'propertyId' => $property->id,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => 1
        ]);
        $reservation->save();
        return response()->json([
            'status' => 'ok',
            'message' => 'Successfully created reservation!'
        ], 201);
    }
}