<?php

namespace App\Http\Controllers;

use App\Models\VisitCategory;
use Illuminate\Http\Request;

class VisitCategoryController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage visit category')) {
            $categories = VisitCategory::where('parent_id', '=', parentId())->get();

            return view('category.index', compact('categories'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $types=VisitCategory::$types;
        return view('category.create',compact('types'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create visit category')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'type' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $visitCategory = new VisitCategory();
            $visitCategory->title = $request->title;
            $visitCategory->type = $request->type;
            $visitCategory->fees = $request->fees;
            $visitCategory->parent_id = parentId();
            $visitCategory->save();

            return redirect()->back()->with('success', __('Visit category successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(VisitCategory $visitCategory)
    {
        //
    }


    public function edit($id)
    {
        $visitCategory=VisitCategory::find($id);
        $types=VisitCategory::$types;
        return view('category.edit',compact('visitCategory','types'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit visit category')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'type' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $visitCategory=VisitCategory::find($id);
            $visitCategory->title = $request->title;
            $visitCategory->type = $request->type;
            $visitCategory->fees = $request->fees;
            $visitCategory->save();

            return redirect()->back()->with('success', __('Visit category successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete visit category')) {
            $visitCategory=VisitCategory::find($id);
            $visitCategory->delete();
            return redirect()->back()->with('success', 'Visit category successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
