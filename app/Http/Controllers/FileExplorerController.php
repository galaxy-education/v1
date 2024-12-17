<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileExplorerController extends Controller
{
    public function index()
    {
        // قراءة جميع الملفات من storage/app/public
        $files = Storage::allFiles('public'); // يمكنك تخصيص المسار حسب الحاجة
        $fileDetails = [];

        foreach ($files as $file) {
            $fileDetails[] = [
                'name' => basename($file),
                'path' => $file,
                'url' => Storage::url($file),
                'type' => Storage::mimeType($file),
                'size' => Storage::size($file),
                'last_modified' => date('Y-m-d H:i:s', Storage::lastModified($file)),
            ];
        }

        return view('file-explorer.index', compact('fileDetails'));
    }

    public function delete(Request $request)
    {
        $filePath = $request->get('file');
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على الملف');
    }
}
