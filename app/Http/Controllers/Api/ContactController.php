<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Resources\Api\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\ContactCollection
     */
    public function index(Request $request)
    {
        $contacts = Contact::paginate();

        return ContactResource::collection($contacts);
    }

    /**
     * @param \App\Http\Requests\Api\ContactRequest $request
     * @return \App\Http\Resources\Api\ContactResource
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        return ContactResource::make($contact);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contact $contact
     * @return \App\Http\Resources\Api\ContactResource
     */
    public function show(Request $request, Contact $contact)
    {
        return ContactResource::make($contact);
    }

    /**
     * @param \App\Http\Requests\Api\ContactRequest $request
     * @param \App\Models\Contact $contact
     * @return \App\Http\Resources\Api\ContactResource
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return ContactResource::make($contact);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}
