<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicContent;
use App\Models\HomePage;

class DynamicContentController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'en' => 'required|string',
            'ar' => 'required|string',
        ]);

        $home = HomePage::find(1); // أو ID الديناميكي
        $fieldEn = $request->field . '_en';
        $fieldAr = $request->field . '_ar';

        $home->$fieldEn = $request->en;
        $home->$fieldAr = $request->ar;
        $home->save();

        return response()->json(['message' => 'تم التحديث بنجاح']);
    }


}
