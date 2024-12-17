<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{


    public function updateHome(Request $request)
    {
        $validatedData = $request->validate([
            'home.en.title' => 'required|string|max:255',
            'home.en.paragraph' => 'required|string',
            'home.en.button1' => 'required|string|max:255',
            'home.en.button2' => 'required|string|max:255',
            'home.ar.title' => 'required|string|max:255',
            'home.ar.paragraph' => 'required|string',
            'home.ar.button1' => 'required|string|max:255',
            'home.ar.button2' => 'required|string|max:255',
        ]);

        // تحديث المحتوى في قاعدة البيانات
        $pageContent = PageContent::firstOrCreate(['id' => 1]);
        $pageContent->home = $request->input('home');
        $pageContent->save();

        return response()->json(['success' => true, 'message' => 'Content updated successfully!']);
    }
}
