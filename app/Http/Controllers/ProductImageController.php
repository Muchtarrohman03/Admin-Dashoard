<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $image)
    {
        // Hapus file dari storage
        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        // Hapus record dari database
        $image->delete();

        return back()->with('success', 'Gambar carousel berhasil dihapus.');
    }
}
