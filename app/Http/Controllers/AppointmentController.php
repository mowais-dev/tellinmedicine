<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentNotificationMail;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\NotificationEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:50',
            'patient_email' => 'required|email|max:255',
            'patient_age' => 'nullable|integer|min:1|max:120',
            'is_disabled' => 'nullable|boolean',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:100',
            'care_model' => 'required|string|max:100',
            'reason' => 'nullable|string|max:1000',
            'other_reason' => 'nullable|string|max:1000',
        ], [
            'appointment_date.after_or_equal' => 'Appointments cannot be booked for past dates. Please select today or a future date.',
        ]);

        // Dynamic practice hours from database settings
        $clinicHours = Setting::get('hours_clinic_text') ?: 'Mon - Sat: 10 AM - 2 PM (In-Clinic)';
        $telehealthHours = Setting::get('hours_telehealth_text') ?: 'Mon - Sat: 2 PM - 7 PM (E-Appointments)';
        $sundayHours = Setting::get('hours_sunday_text') ?: 'Sunday: Closed (E-Appointments Only)';

        // Server-side Sunday check: Physical clinic and home visits are closed on Sundays (E-Appointments only)
        $isSunday = \Carbon\Carbon::parse($validated['appointment_date'])->isSunday();
        $careModelLower = strtolower($validated['care_model']);
        $teleSettingLower = strtolower(Setting::get('booking_model_telehealth') ?: '');
        $isTelehealth = str_contains($careModelLower, 'tele')
            || str_contains($careModelLower, 'e-appointment')
            || str_contains($careModelLower, 'e appointment')
            || str_contains($careModelLower, 'eappointment')
            || str_contains($careModelLower, 'virtual')
            || str_contains($careModelLower, 'online')
            || ($teleSettingLower !== '' && str_contains($careModelLower, $teleSettingLower));

        if ($isSunday && !$isTelehealth) {
            return response()->json([
                'success' => false,
                'message' => "The physical clinic and Home Visits are closed on Sundays ({$sundayHours}). Please select E-Appointments for Sunday care or choose a weekday for In-Clinic visits.",
            ], 422);
        }

        // Validate time slot against dynamic practice hours
        try {
            $carbonTime = \Carbon\Carbon::parse($validated['time_slot']);
            $totalMins = $carbonTime->hour * 60 + $carbonTime->minute;

            $parseRange = function($hoursText, $defStart, $defEnd) {
                if (empty($hoursText)) return [$defStart, $defEnd];
                preg_match_all('/(\d{1,2})(?::(\d{2}))?\s*(AM|PM)/i', $hoursText, $matches, PREG_SET_ORDER);
                if (count($matches) < 2) return [$defStart, $defEnd];
                $toMins = function($m) {
                    $h = (int)$m[1]; $min = !empty($m[2]) ? (int)$m[2] : 0; $p = strtoupper($m[3]);
                    if ($p === 'PM' && $h < 12) $h += 12;
                    if ($p === 'AM' && $h === 12) $h = 0;
                    return $h * 60 + $min;
                };
                return [$toMins($matches[0]), $toMins($matches[1])];
            };

            if (!$isTelehealth) {
                [$startMins, $endMins] = $parseRange($clinicHours, 600, 840);
                if ($totalMins < $startMins || $totalMins > $endMins) {
                    return response()->json([
                        'success' => false,
                        'message' => "In-Clinic Visits and Home Visits are available during active clinic hours ({$clinicHours}). For other time slots, please select E-Appointments.",
                    ], 422);
                }
            } else {
                [$startMins, $endMins] = $parseRange($telehealthHours, 840, 1140);
                if ($totalMins < $startMins || $totalMins > $endMins) {
                    return response()->json([
                        'success' => false,
                        'message' => "E-Appointments (Virtual Care) are available during practice telehealth hours ({$telehealthHours}).",
                    ], 422);
                }
            }
        } catch (\Throwable $e) {
            // Ignore time format parsing errors
        }

        // Server-side Home Visit Eligibility check
        if (str_contains(strtolower($validated['care_model']), 'home')) {
            $age = isset($validated['patient_age']) ? (int)$validated['patient_age'] : 0;
            $isDisabled = !empty($validated['is_disabled']);
            if ($age < 65 && !$isDisabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Physician Home Visits are exclusively available for patients aged 65 or older, or individuals with disabilities.',
                ], 422);
            }
        }

        $rawOther = trim($request->input('other_reason', ''));
        $rawReason = trim($request->input('reason', ''));

        if ($rawOther !== '') {
            $validated['reason'] = $rawOther;
        } elseif (!empty($rawReason)) {
            $validated['reason'] = $rawReason;
        }

        unset($validated['other_reason']);

        $appointment = Appointment::create($validated);

        // Send email to active notification email recipients
        $recipients = NotificationEmail::where('is_active', true)->pluck('email')->toArray();
        if (empty($recipients)) {
            $settingEmail = Setting::get('email');
            if (!empty($settingEmail) && filter_var($settingEmail, FILTER_VALIDATE_EMAIL)) {
                $recipients[] = $settingEmail;
            }
        }

        foreach (array_unique($recipients) as $recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(new AppointmentNotificationMail($appointment));
            } catch (\Throwable $e) {
                Log::error("Failed to send appointment notification email to {$recipientEmail}: " . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you, ' . $appointment->patient_name . '! Your appointment request for [' . $appointment->care_model . '] on ' . \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') . ' at ' . $appointment->time_slot . ' has been submitted. Dr. Ngomba\'s team will confirm shortly.',
            'appointment' => $appointment,
        ]);
    }
}
