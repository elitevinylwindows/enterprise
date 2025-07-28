<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage Page')) {
            $Pages = Page::get();
            return view('Pages.index', compact('Pages'));
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
        if (\Auth::user()->can('create Page')) {
            return view('Pages.create');
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
        if (\Auth::user()->can('create Page')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $page = new Page();
            $page->title = $request->title;
            $page->slug = strtolower(str_replace([' '],['_'], $request->title));
            $page->content = $request->content;
            $page->enabled = $request->enabled;
            $page->parent_id = \Auth::user()->id;
            $page->save();

            return redirect()->back()->with('success', __('Page successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        if (\Auth::user()->can('show Page')) {
            return view('Pages.show', compact('page'));
        } else {
            $return['status'] = 'error';
            $return['messages'] = __('Permission denied.');
            return response()->json($return);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        if (\Auth::user()->can('edit Page')) {
            return view('Pages.edit', compact('page'));
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
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        if (\Auth::user()->can('edit Page') ) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $page->title = $request->title;
            $page->slug = strtolower(str_replace([' '],['_'], $request->title));
            $page->content = $request->content;
            $page->enabled = $request->enabled;
            $page->save();

            return redirect()->back()->with('success', __('Page successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (\Auth::user()->can('delete Page')) {
            $page->delete();
            return redirect()->back()->with('success', 'Page successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function page(Request $request, $slug)
    {
        $page = Page::where('slug', $request->slug)->first();
        if ($page) {
            return view('Pages.page', compact('page'));
        } else {
            return redirect()->back()->with('error', __('Page not found.'));
        }
    }
}
