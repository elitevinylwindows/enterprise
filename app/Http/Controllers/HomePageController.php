<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use App\Models\Page;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('manage home page')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $loginUser = Auth::user();
        $pages = Page::where('enabled', 1)->pluck('title', 'id');
        $HomePage = HomePage::get();
        return view('home_pages.index', compact('loginUser', 'pages', 'HomePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function show(HomePage $homePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePage $homePage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePage $homePage, $id)
    {
        if (!Auth::user()->can('edit home page')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $homePage = HomePage::find($id);
        $old_content_value = '';
        if (!empty($request->content_value)) {
            $old_content_value = json_decode($homePage->content_value, true);
        }
        $content_value = $request->content_value;

        if (!empty($request->content_value['section_footer_image'])) {
            $section_footer_image = $request->content_value['section_footer_image'];
            $filenameWithExt = $section_footer_image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $section_footer_image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_section_footer_image_' . date('Ymdhisa') . '.' . $extension;

            $dir = storage_path('upload/homepage/');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $section_footer_image->storeAs('upload/homepage/', $fileNameToStore);
            $content_value['section_footer_image_path'] = 'upload/homepage/' . $fileNameToStore;
        } else {
            $content_value['section_footer_image_path'] = !empty($old_content_value['section_footer_image_path']) ? $old_content_value['section_footer_image_path'] : '';
        }

        if (!empty($request->content_value['section_main_image'])) {
            $section_main_image = $request->content_value['section_main_image'];
            $filenameWithExt = $section_main_image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $section_main_image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_section_main_image_' . date('Ymdhisa') . '.' . $extension;

            $dir = storage_path('upload/homepage/');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $section_main_image->storeAs('upload/homepage/', $fileNameToStore);
            $content_value['section_main_image_path'] = 'upload/homepage/' . $fileNameToStore;
        } else {
            $content_value['section_main_image_path'] = !empty($old_content_value['section_main_image_path']) ? $old_content_value['section_main_image_path'] : '';
        }

        for ($i = 1; $i <= 3; $i++) {
            if (!empty($request->content_value['box' . $i . '_number_image'])) {
                $box_image_path = $request->content_value['box' . $i . '_number_image'];
                $filenameWithExt = $box_image_path->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $box_image_path->getClientOriginalExtension();
                $fileNameToStore = $filename . '_box_image_path_' . $i . date('Ymdhisa') . '.' . $extension;

                $dir = storage_path('upload/homepage/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $box_image_path->storeAs('upload/homepage/', $fileNameToStore);
                $content_value['box_image_' . $i . '_path'] = 'upload/homepage/' . $fileNameToStore;
            } else {
                $content_value['box_image_' . $i . '_path'] = !empty($old_content_value['box_image_' . $i . '_path']) ? $old_content_value['box_image_' . $i . '_path'] : '';
            }
        }

        for ($ik = 1; $ik <= 2; $ik++) {
            if (!empty($request->content_value['Box' . $ik . '_image'])) {
                $box_image_path = $request->content_value['Box' . $ik . '_image'];
                $filenameWithExt = $box_image_path->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $box_image_path->getClientOriginalExtension();
                $fileNameToStore = $filename . '_Section_33_image_' . $ik . date('Ymdhisa') . '.' . $extension;

                $dir = storage_path('upload/homepage/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $box_image_path->storeAs('upload/homepage/', $fileNameToStore);
                $content_value['Box' . $ik . '_image_path'] = 'upload/homepage/' . $fileNameToStore;
            } else {
                $content_value['Box' . $ik . '_image_path'] = !empty($old_content_value['Box' . $ik . '_image_path']) ? $old_content_value['Box' . $ik . '_image_path'] : '';
            }
        }

        for ($is4 = 1; $is4 <= 6; $is4++) {
            if (!empty($request->content_value['Sec4_box' . $is4 . '_image'])) {
                $box_image_path = $request->content_value['Sec4_box' . $is4 . '_image'];
                $filenameWithExt = $box_image_path->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $box_image_path->getClientOriginalExtension();
                $fileNameToStore = $filename . '_Section_4_image_' . $is4 . date('Ymdhisa') . '.' . $extension;

                $dir = storage_path('upload/homepage/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $box_image_path->storeAs('upload/homepage/', $fileNameToStore);
                $content_value['Sec4_box' . $is4 . '_image_path'] = 'upload/homepage/' . $fileNameToStore;
            } else {
                $content_value['Sec4_box' . $is4 . '_image_path'] = !empty($old_content_value['Sec4_box' . $is4 . '_image_path']) ? $old_content_value['Sec4_box' . $is4 . '_image_path'] : '';
            }
        }

        if (!empty($content_value['Sec6_Box_title'])) {
            for ($is6 = 0; $is6 <= count($content_value['Sec6_Box_title']); $is6++) {
                if (!empty($request->content_value['Sec6_box_image'][$is6])) {
                    $box_image_path = $request->content_value['Sec6_box_image'][$is6];
                    $filenameWithExt = $box_image_path->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $box_image_path->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_Section_6_image_' . $is6 . date('Ymdhisa') . '.' . $extension;

                    $dir = storage_path('upload/homepage/');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }

                    $box_image_path->storeAs('upload/homepage/', $fileNameToStore);
                    $content_value['Sec6_box' . $is6 . '_image_path'] = 'upload/homepage/' . $fileNameToStore;
                } else {
                    $content_value['Sec6_box' . $is6 . '_image_path'] = !empty($old_content_value['Sec6_box' . $is6 . '_image_path']) ? $old_content_value['Sec6_box' . $is6 . '_image_path'] : '';
                }
            }
        }

        for ($is7 = 1; $is7 <= 8; $is7++) {
            if (!empty($request->content_value['Sec7_box'.$is7.'_image'])) {
                $box_image_path = $request->content_value['Sec7_box'.$is7.'_image'];
                $filenameWithExt = $box_image_path->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $box_image_path->getClientOriginalExtension();
                $fileNameToStore = $filename . '_Section_7_image_' . $is7 . date('Ymdhisa') . '.' . $extension;

                $dir = storage_path('upload/homepage/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $box_image_path->storeAs('upload/homepage/', $fileNameToStore);
                $content_value['Sec7_box' . $is7 . '_image_path'] = 'upload/homepage/' . $fileNameToStore;
            } else {
                $content_value['Sec7_box' . $is7 . '_image_path'] = !empty($old_content_value['Sec7_box' . $is7 . '_image_path']) ? $old_content_value['Sec7_box' . $is7 . '_image_path'] : '';
            }
        }



        $homePage->content_value = $content_value;
        $homePage->save();
        return redirect()->back()->with('tab', $request->tab)->with('success', __('Home Page Content Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomePage $homePage)
    {
        //
    }
}
