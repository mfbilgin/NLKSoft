<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\RedirectResponse;

class ImageController extends Controller
{
    public function deleteImage($id): RedirectResponse
    {

        $image = Image::find($id);
        unlink(public_path($image->url));
        $image->delete();
        return redirect()->back()->with('info', 'Resim başarıyla silindi.');

    }
}
