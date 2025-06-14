<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    /**
     * Save file function.
     */
    public function fileUpload(array|object $images, string $path): string
    {
        if (empty($path) || !is_string($path)) {
            throw new \InvalidArgumentException("Upload path must be a non-empty string.");
        }

        $imageName = '';

        if (is_array($images)) {
            foreach ($images as $image) {
                $newName = Carbon::now()->timestamp . random_int(0, 20) . '.' . $image->extension();
                $imageName .= $newName . ' ';
                $image->storeAs('public/' . $path, $newName);
            }
            $imageName = rtrim($imageName);
        } else {
            $imageName = Carbon::now()->timestamp . '1.' . $images->extension();
            Storage::makeDirectory($path);
            $images->storeAs($path, $imageName);
        }

        return $imageName;
    }


    /**
     * Delete file function.
     */
    public function fileDestroy(array|string $images, string $path): bool
    {
        if (is_array($images)) {
            foreach ($images as $image) {
                $fullPath = $path . '/' . $image;
                if (Storage::disk('public')->exists($fullPath)) {
                    Storage::disk('public')->delete($fullPath);
                }
            }
            return true;
        } else {
            $fullPath = $path . '/' . $images;
            // dd($images, Storage::disk('public')->exists($fullPath), $fullPath);

            if (Storage::disk('public')->exists($fullPath)) {
                return Storage::disk('public')->delete($fullPath);
            }
        }

        return false;
    }
}
