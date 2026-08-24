<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationEmail;
use App\Models\Setting;
use App\Mail\ConciergeSubscriptionMail;
use Illuminate\Support\Facades\Mail;

class ConciergeSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:50',
            'patient_email' => 'required|email|max:255',
            'plan_name' => 'required|string|max:255',
            'plan_price' => 'nullable|string|max:255',
            'patient_notes' => 'nullable|string|max:2000',
        ]);

        $details = [
            'patient_name' => $validated['patient_name'],
            'patient_phone' => $validated['patient_phone'],
            'patient_email' => $validated['patient_email'],
            'plan_name' => $validated['plan_name'],
            'plan_price' => $validated['plan_price'] ?? null,
            'patient_notes' => $validated['patient_notes'] ?? null,
            'submitted_at' => date('F j, Y, g:i a'),
        ];

        // Retrieve active notification recipients configured in admin portal
        $recipients = NotificationEmail::where('is_active', true)->pluck('email')->toArray();
        if (empty($recipients)) {
            $settingEmail = Setting::get('email', 'tellinmedicinellc@gmail.com');
            $recipients = [$settingEmail];
        }

        try {
            foreach ($recipients as $recipientEmail) {
                Mail::to(trim($recipientEmail))->send(new ConciergeSubscriptionMail($details));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Concierge subscription mail delivery error: ' . $e->getMessage());
        }

        $successMsg = Setting::get('concierge_modal_success_msg') ?: "Your Concierge Plan subscription inquiry has been sent successfully! Dr. Ngomba's care team will contact you shortly.";

        return response()->json([
            'success' => true,
            'message' => $successMsg,
            'plan_name' => $validated['plan_name'],
        ]);
    }
}
