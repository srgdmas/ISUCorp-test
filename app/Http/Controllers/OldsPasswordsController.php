<?php

namespace App\Http\Controllers;

use App\Http\Requests\OldsPasswordsRequest;
use App\Models\OldsPasswords;

class OldsPasswordsController extends Controller
{
    public function index()
    {
        $oldspasswords = OldsPasswords::latest()->get();

        return response(['data' => $oldspasswords ], 200);
    }

    public function store(OldsPasswordsRequest $request)
    {
        $oldspasswords = OldsPasswords::create($request->all());

        return response(['data' => $oldspasswords ], 201);

    }

    public function show($id)
    {
        $oldspasswords = OldsPasswords::findOrFail($id);

        return response(['data', $oldspasswords ], 200);
    }

    public function update(OldsPasswordsRequest $request, $id)
    {
        $oldspasswords = OldsPasswords::findOrFail($id);
        $oldspasswords->update($request->all());

        return response(['data' => $oldspasswords ], 200);
    }

    public function destroy($id)
    {
        OldsPasswords::destroy($id);

        return response(['data' => null ], 204);
    }
}
