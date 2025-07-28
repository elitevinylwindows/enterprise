<?php

namespace App\Http\Controllers;

use App\Models\AuthPage;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class AuthPageController extends Controller
{

    public function index()
    {
        $authPage = AuthPage::where('parent_id', parentId())->first();

        $titles = $authPage && !empty($authPage->title) ? json_decode($authPage->title, true) : [];
        $descriptions = $authPage && !empty($authPage->description) ? json_decode($authPage->description, true) : [];

        return view('auth_page.authPage', compact('authPage', 'titles', 'descriptions'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(AuthPage $authPage)
    {
        //
    }


    public function edit(AuthPage $authPage)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'section' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $authPage = AuthPage::firstOrCreate(['parent_id' => parentId()]);

        $authPage->title = $request->title ?? [];
        $authPage->description = $request->description ?? [];
        $authPage->section = $request->section === '1';


        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageFilenameWithExt = $image->getClientOriginalName();
            $imageFilename = pathinfo($imageFilenameWithExt, PATHINFO_FILENAME);
            $imageExtension = $image->getClientOriginalExtension();
            $imageFileName = time() . '.' . $imageExtension;
            $dir = storage_path('upload/images');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $image->move($dir, $imageFileName);
            $authPage->image = 'upload/images/' . $imageFileName;
        }


        $authPage->save();

        return redirect()->route('authPage.index')->with('success', 'Auth Page updated successfully.');
    }






    public function destroy(AuthPage $authPage)
    {
        //
    }
}
