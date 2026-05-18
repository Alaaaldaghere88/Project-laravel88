<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait BaseImages
{

public function update_image($oldPath, $file, $directory)
{
    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->delete($oldPath);
    }

    return $file->store($directory, 'public');
}

public function create_image($file, $directory)
{
    return $file->store($directory, 'public');
}

public function delete_image($oldPath)
{
    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->delete($oldPath);
    }
}
}
