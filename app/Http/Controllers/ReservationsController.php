<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationsRequest;
use App\Models\Reservations;
use Illuminate\Support\Facades\Validator;

class ReservationsController extends Controller
{
    const relations = ['contact_type'];

    public function index()
    {
        $reservations = Reservations::with(self::relations)->get();

        return response(['data' => $reservations ], 200);
    }

    public function store(ReservationsRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'contact_name' => 'required',
            'birth_day' => 'required',
            'contact_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()->messages()],400);
        }

        try {

            $reservations = Reservations::create($request->all());

            return response(['data' => $reservations ], 201);

        } catch (\Exception $e) {

            return response(['message' => 'Some error happen while trait to insert the contact reservation' ], 400);
        }

    }

    public function show($id)
    {
        $reservations = Reservations::findOrFail($id);

        return response(['data', $reservations ], 200);
    }

    public function update(ReservationsRequest $request, $id)
    {
        $reservations = Reservations::findOrFail($id);
        $reservations->update($request->all());

        return response(['data' => $reservations ], 200);
    }

    public function destroy($id)
    {
        Reservations::destroy($id);

        return response(['data' => null ], 204);
    }
}
