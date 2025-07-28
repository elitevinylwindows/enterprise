<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Subscription;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage contact') ) {
            $contacts = Contact::where('parent_id', \Auth::user()->id)->get();
            return view('contact.index', compact('contacts'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        return view('contact.create');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create contact') ) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_number = $request->contact_number;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->parent_id = \Auth::user()->id;
            $contact->save();

            return redirect()->back()->with('success', __('Contact successfully created.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function show(Contact $contact)
    {
        //
    }


    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }


    public function update(Request $request, Contact $contact)
    {
        if (\Auth::user()->can('edit contact') ) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_number = $request->contact_number;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            return redirect()->back()->with('success', __('Contact successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function destroy(Contact $contact)
    {
        if (\Auth::user()->can('edit contact') ) {
            $contact->delete();

            return redirect()->back()->with('success', 'Contact successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
