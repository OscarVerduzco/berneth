<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\DB;


class PropertyController extends Controller
{
    public function getAll()
    {
        $properties = Property::all();
        return response()->json($properties);
    }

    //function to create a property
    public function createProperty(Request $request)
    {
        try{
            DB::beginTransaction();
            $property = Property::create([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                //'state' => $request->state,
                'zipCode' => $request->zipCode,
                'price' => $request->price,
                'userId' => $request->userId,
                'status' => 1
            ]);
            $property->save();
            DB::commit();
            return response()->json([
                'status' => 'ok',
                'message' => 'Successfully created property!'
            ], 201);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        
        }
    }
        
    //function to update a property
    public function updateProperty(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $property = Property ::find($id);
            $property->name = $request->name;
            $property->description = $request->description;
            $property->address = $request->address;
            $property->city = $request->city;
            $property->country = $request->country;
            //$property->state = $request->state;
            $property->zipCode = $request->zipCode;
            $property->userId = $request->userId;
            $property->price = $request->price;
            //$property->status = 1;
            $property->save();
            DB::commit();
            return response()->json([
                'status' => 'ok',
                'message' => 'Successfully updated property!'
            ], 201);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating property!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //function to delete a property
    public function deleteProperty($id)
    {
        DB::beginTransaction();
        try{
            $property = Property::find($id);
            $property->status = 0;
            $property->save();
            DB::commit();
            return response()->json([
                'status' => 'ok',
                'message' => 'Successfully deleted property!'
            ], 201);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting property!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //function to search a property
    public function search($request)
    {
        $properties = Property::where('name', 'like', '%'.$request.'%')
        ->orWhere('description', 'like', '%'.$request.'%')
        ->orWhere('address', 'like', '%'.$request.'%')
        ->orWhere('city', 'like', '%'.$request.'%')
        ->orWhere('state', 'like', '%'.$request.'%')
        ->orWhere('zipCode', 'like', '%'.$request.'%')
        ->get();
        return response()->json($properties);
    }

    //fucntion to upsert
    public function upsertProperty(Request $request)
    {
        DB::beginTransaction();
        try{
            $id=$request->id;
            if($id==null){
                $property = Property::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'address' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                    //'state' => $request->state,
                    'zipCode' => $request->zipCode,
                    'price' => $request->price,
                    'userId' => $request->userId,
                    'status' => 1
                ]);
                $property->save();
                DB::commit();
                return response()->json([
                    'status' => 'ok',
                    'message' => 'Successfully created property!'
                ], 201);
            }else{
                $property = Property ::find($id);
                if($property){

                    $property->name = $request->name;
                    $property->description = $request->description;
                    $property->address = $request->address;
                    $property->city = $request->city;
                    $property->country = $request->country;
                    //$property->state = $request->state;
                    $property->zipCode = $request->zipCode;
                    $property->userId = $request->userId;
                    $property->price = $request->price;
                    //$property->status = 1;
                    $property->save();
                    DB::commit();
                    return response()->json([
                        'status' => 'ok',
                        'message' => 'Successfully updated property!'
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Property not found!'
                    ], 200);
                }
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating property!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}