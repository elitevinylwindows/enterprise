<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage template')) {
            $templates = Template::where('parent_id', parentId())->get();
            return view('template.index', compact('templates'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

   public function create()
{
    $templateModules = Template::$modules;
    $template_option = [];

    foreach ($templateModules as $key => $value) {
        $template_option[$key] = $value['name'];
    }

    return view('template.create', compact('template_option', 'templateModules'));
}


    public function store(Request $request)
    {
        if (\Auth::user()->can('create template')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'module' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $exist = Template::where('parent_id', parentId())->where('module', $request->module)->first();
            if (empty($exist)) {
                $template = new Template();
                $template->name = $request->name;         // human-readable
$template->module = $request->module;     // internal use

                $template->subject = $request->subject;
                $template->message = $request->message;
                $template->enabled_email = isset($request->enabled_email) ? 1 : 0;
                $template->parent_id = parentId();
                $template->save();

                return redirect()->route('template.index')->with('success', __('Template successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Template already exists.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Template $template)
    {
        //
    }

public function edit(Template $template)
{
    $short_code = $template->short_code;
    $template->short_code = json_decode($short_code);

    $templateModules = Template::$modules;
    $template_option = [];

    foreach ($templateModules as $key => $value) {
        $template_option[$key] = $value['name'];
    }

    return view('template.edit', compact('template', 'template_option', 'templateModules'));
}



    public function update(Request $request, Template $template)
    {
        if (\Auth::user()->can('edit template')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $template->name = $request->name;         // human-readable
$template->module = $request->module;     // internal use

            $template->subject = $request->subject;
            $template->message = $request->message;
            $template->enabled_email = $request->enabled_email;
            $template->save();

            return redirect()->route('template.index')->with('success', __('Template successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Template $template)
    {
        if (\Auth::user()->can('delete template')) {
            $template->delete();
            return redirect()->back()->with('success', __('Template successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
