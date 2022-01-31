<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactsTypesRequest;
use App\Models\ContactsTypes;

class ContactsTypesController extends Controller
{
    public function index()
    {
        $contactstypes = ContactsTypes::all();

        return response(['data' => $contactstypes ], 200);
    }

    public function store(ContactsTypesRequest $request)
    {
        $contactstypes = ContactsTypes::create($request->all());

        return response(['data' => $contactstypes ], 201);

    }

    public function show($id)
    {
        $contactstypes = ContactsTypes::findOrFail($id);

        return response(['data', $contactstypes ], 200);
    }

    public function update(ContactsTypesRequest $request, $id)
    {
        $contactstypes = ContactsTypes::findOrFail($id);
        $contactstypes->update($request->all());

        return response(['data' => $contactstypes ], 200);
    }

    public function destroy($id)
    {
        ContactsTypes::destroy($id);

        return response(['data' => null ], 204);
    }
}
