<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileSetupController extends Controller
{
    public function showForm()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $invitation = Invitation::where('user_id', $user->id)->first();

        return view('dashboard.index', compact('profile', 'invitation'));
    }

    public function saveStep1(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return response()->json(['success' => true]);
    }

    public function saveStep2(Request $request)
    {
        $validated = $request->validate([
            'education_levels' => 'nullable|string',
            'moduels' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'about' => 'nullable|string',
            'baba_phone' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $validated['photo'] = $path;
        }

        $profile = Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        // Generate invitation code if not exists
        $invitation = Invitation::firstOrCreate(
            ['user_id' => auth()->id()],
            ['invitation_code' => strtoupper(Str::random(8))]
        );

        return response()->json([
            'success' => true,
            'invitation_code' => $invitation->invitation_code
        ]);
    }

    public function saveStep3(Request $request)
    {
        $validated = $request->validate([
            'friend_invitation_code' => 'required|string|exists:invitations,invitation_code',
        ]);

        $invitation = Invitation::where('invitation_code', $validated['friend_invitation_code'])
            ->where('user_id', '!=', auth()->id())
            ->firstOrFail();

        $usedBy = json_decode($invitation->used_by ?? '[]');
        $usedBy[] = auth()->id();
        $invitation->used_by = json_encode(array_unique($usedBy));
        $invitation->save();

        return response()->json(['success' => true]);
    }

    public function verifyInvitation(Request $request)
    {
        $code = $request->input('code');
        $invitation = Invitation::where('invitation_code', $code)
            ->where('user_id', '!=', auth()->id())
            ->first();

        if (!$invitation) {
            return response()->json(['valid' => false]);
        }

        $usedBy = json_decode($invitation->used_by ?? '[]');
        if (in_array(auth()->id(), $usedBy)) {
            return response()->json(['valid' => false, 'message' => 'You have already used this invitation code']);
        }

        return response()->json(['valid' => true]);
    }
}
