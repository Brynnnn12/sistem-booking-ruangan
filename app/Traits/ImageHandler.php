<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    /**
     * Upload gambar dengan penamaan yang konsisten
     */
    protected function uploadImage($file, string $name, string $prefix = 'image'): string
    {
        $slug = Str::slug($name);
        $filename = $prefix . '-' . $slug . '-' . time() . '.' . $file->getClientOriginalExtension();

        // storeAs mengembalikan path relatif: "folder/filename.jpg"
        return $file->storeAs($this->getImageFolder(), $filename, 'public');
    }

    /**
     * Hapus file gambar fisik
     */
    protected function deletePhysicalFile(?string $path): void
    {
        if (!$path) return;

        // Path sudah relatif (contoh: "rooms/filename.jpg")
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Get folder untuk menyimpan gambar
     * Override di class yang menggunakan trait ini
     */
    protected function getImageFolder(): string
    {
        return 'images';
    }
}
