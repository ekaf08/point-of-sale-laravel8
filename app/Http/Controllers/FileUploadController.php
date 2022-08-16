<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    // Fungsi Penanganan Upload Gambar dari FilePond
    public function store(Request $request)
    {
        if ($request->hasFile('imageAttachment')) {
            $file = $request->file('imageAttachment');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . "-" . now()->timestamp;
            $file->storeAs('public/image/' . $folder, $filename);
            return $folder;
        }
        return;
    }

    // Fungsi untuk menambahkan data 
    public function save($data)
    {
        User::create($data);
        return;
    }

    // Revert Filepond - Fungsi untuk handle ketika melakukan pembatalan.
    public function delete(Request $request)
    {
        $id = $request->getContent();
        Storage::disk('public')->deleteDirectory('image/' . $id);
    }
}
