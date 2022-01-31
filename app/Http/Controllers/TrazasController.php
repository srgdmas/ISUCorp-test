<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrazasRequest;
use App\Models\Trazas;

class TrazasController extends Controller
{
    public function index()
    {
        if (auth()->user()->roles_id == 1 || auth()->user()->roles_id == 2) {
            $trazas = Trazas::with('users')->get();
        } else {
            $trazas = Trazas::with('users')->where('users_id',auth()->user()->id)->get();
        }

        return response(['data' => $trazas ], 200);
    }

    public function store(TrazasRequest $request)
    {
        $trazas = Trazas::create($request->all());

        return response(['data' => $trazas ], 201);

    }

    public function show($id)
    {
        $trazas = Trazas::findOrFail($id);

        return response(['data', $trazas ], 200);
    }

    public function update(TrazasRequest $request, $id)
    {
        $trazas = Trazas::findOrFail($id);
        $trazas->update($request->all());

        return response(['data' => $trazas ], 200);
    }

    public function destroy($id)
    {
        Trazas::destroy($id);

        return response(['data' => null ], 204);
    }
}
