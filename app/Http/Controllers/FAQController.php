<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage FAQ')) {
            $FAQs = FAQ::get();
            return view('FAQ.index', compact('FAQs'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('create FAQ')) {
            return view('FAQ.create');
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('create FAQ')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'question' => 'required',
                    'description' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $fAQ = new FAQ();
            $fAQ->question = $request->question;
            $fAQ->description = $request->description;
            $fAQ->enabled = $request->enabled;
            $fAQ->parent_id = \Auth::user()->id;
            $fAQ->save();

            return redirect()->back()->with('success', __('FAQ successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit FAQ')) {
            $FAQ = FAQ::find($id);
            if ($FAQ) {
                return view('FAQ.edit', compact('FAQ'));
            } else {
                $return['status'] = 'error';
                $return['messages'] = __('FAQ not found.');
                return response()->json($return);
            }
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FAQ $fAQ, $id)
    {
        if (\Auth::user()->can('edit FAQ') ) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'question' => 'required',
                    'description' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $fAQ = FAQ::find($id);
            $fAQ->question = $request->question;
            $fAQ->description = $request->description;
            $fAQ->enabled = $request->enabled;
            $fAQ->save();

            return redirect()->back()->with('success', __('FAQ successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FAQ  $fAQ
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('delete FAQ')) {
            $fAQ = FAQ::find($id);
            if ($fAQ) {
                $fAQ->delete();
                return redirect()->back()->with('success', 'FAQ successfully deleted.');
            } else {
                return redirect()->back()->with('error', 'FAQ not found.');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
