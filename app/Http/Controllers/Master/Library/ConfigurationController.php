<?php

namespace App\Http\Controllers\Master\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ConfigurationController extends Controller
{
    public function index()
{
    $series = \App\Models\Master\Series\Series::select('id', 'series')->get();

$seriesList = [];
foreach ($series as $item) {
    $seriesList[$item->series] = [];
}

return view('master.library.configurations.index', compact('seriesList'));
}




public function show($seriesName)
{
    $seriesName = urldecode($seriesName);
    $seriesPath = public_path("config-thumbs/" . trim($seriesName, '/'));

    \Log::info("Looking for series folder at: " . $seriesPath);

    if (!is_dir($seriesPath)) {
        return response("<p class='text-danger'>Series folder not found at path: {$seriesPath}</p>", 404);
    }

    $categories = array_filter(glob("{$seriesPath}/*"), 'is_dir');

    ob_start();
    echo "<div class='px-4'>"; // Padding wrapper
    echo "<div class='accordion' id='accordionSeries'>";

    foreach ($categories as $catPath) {
        $category = basename($catPath);
        $categoryId = preg_replace('/[^a-zA-Z0-9]/', '_', $category); // Safe ID for collapse target

        $images = glob("{$catPath}/*.{jpg,jpeg,png}", GLOB_BRACE);

        echo "<div class='accordion-item mb-3'>";
        echo "<h2 class='accordion-header'>";
        echo "<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#cat{$categoryId}'>";
        echo "{$category}</button></h2>";
        echo "<div id='cat{$categoryId}' class='accordion-collapse collapse'><div class='accordion-body'>";
        echo "<div class='row g-2'>";

        foreach ($images as $img) {
            $imgName = basename($img);
            $imgUrl = url("library-image/{$seriesName}/{$category}/{$imgName}");

            echo "<div class='col-md-3'><div class='card h-100 text-center shadow-sm'>";
            echo "<img src='{$imgUrl}' class='card-img-top' style='height:130px; object-fit:contain;'>";
            echo "<div class='card-body p-2'><small>{$imgName}</small></div>";
            echo "</div></div>";
        }

        echo "</div></div></div></div>";
    }

    echo "</div></div>"; // close accordion and wrapper

    return response(ob_get_clean());
}








    public function addCategory(Request $request, $series)
    {
        $name = Str::slug($request->category_name);
        $path = public_path("config-thumbs/$series/$name");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return back()->with('success', 'Category created.');
    }

public function uploadImage(Request $request, $series, $category)
{
    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // Get base name without extension
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Get the real extension from the uploaded file
        $ext = $file->getClientOriginalExtension();

        // Rebuild clean name: xo.jpg, not xo.jpg.png
        $safeName = $baseName . '.' . strtolower($ext);

        // Move to correct folder
        $file->move(public_path("config-thumbs/$series/$category"), $safeName);
    }

    return back();
}


    public function deleteImage($series, $category, $image)
    {
        $file = public_path("config-thumbs/$series/$category/$image");
        if (File::exists($file)) {
            File::delete($file);
        }
        return response()->json(['success' => true]);
    }
}
