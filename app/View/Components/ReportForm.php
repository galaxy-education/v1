<?php

namespace App\View\Components;

use App\Models\Report;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class ReportForm extends Component
{
    public function render()
    {
        return view('components.report-form');
    }

    public function saveReport(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|array',
            'reason.*' => 'string',
            'message' => 'required|string',
        ]);

        // Save the report to the database
        Report::create([
            'user_id' => auth()->id(),
            'reason' => implode(', ', $validated['reason']),
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('status', 'تم تقديم التقرير بنجاح');
    }
}
