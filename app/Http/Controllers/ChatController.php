<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
use App\Models\BookingReason;
use App\Models\Appointment;
use App\Models\NotificationEmail;
use App\Models\ChatWidgetConfig;
use App\Models\Service;
use App\Mail\AppointmentNotificationMail;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $userMessage = trim($validated['message']);
        $history = $validated['history'] ?? [];

        $apiKey = config('services.openai.api_key');

        $chatWidgetConfig = ChatWidgetConfig::first();
        $assistantName = !empty($chatWidgetConfig->assistant_name) ? $chatWidgetConfig->assistant_name : 'TELLinCare Assist';

        // Fetch settings and booking reasons for system prompt context
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $clinicHours = $settings['hours_clinic_text'] ?? 'Mon - Sat: 8 AM - 12 PM (In-Clinic)';
        $telehealthHours = $settings['hours_telehealth_text'] ?? 'Mon - Sat: 12 PM - 6 PM (E-Appointments)';
        $sundayHours = $settings['hours_sunday_text'] ?? 'Sunday: Closed (E-Appointments Only)';
        $phonePrimary = $settings['phone_primary'] ?? '(774) 643-6261';
        $address = $settings['address'] ?? '380 Elm Street Suite 1, North Attleboro, MA 02760';

        $reasonsList = BookingReason::where('is_active', true)->pluck('label')->toArray();
        $reasonsStr = !empty($reasonsList) ? implode(', ', $reasonsList) : 'Primary Care Check-up, Follow-up Visit, Travel Vaccine Consultation, DOT Physical';

        // Dynamically fetch all active services from database
        $activeServices = Service::where('is_active', true)->orderBy('order')->get();
        $servicesLines = [];
        foreach ($activeServices as $svc) {
            $desc = !empty($svc->description) ? trim($svc->description) : 'Comprehensive medical care';
            $servicesLines[] = "- {$svc->title}: {$desc}";
        }
        $dynamicServicesText = !empty($servicesLines) ? implode("\n", $servicesLines) : "- Adult Primary Care: Comprehensive health checkups & chronic care.\n- Physician Home Visits: In-home doctor visits for seniors and mobility-challenged patients.\n- E-Appointments / Telehealth: Virtual care and consultations.\n- Travel Medicine & Vaccines: Destination-specific immunizations.";

        $modelInClinic = $settings['booking_model_in_clinic'] ?? 'In-Clinic';
        $modelHome = $settings['booking_model_home'] ?? 'Home Visit';
        $modelTelehealth = $settings['booking_model_telehealth'] ?? 'E-Appointments';

        $todayDateStr = date('l, F j, Y');
        $todayIso = date('Y-m-d');

        $systemPrompt = "You are {$assistantName}, the official intelligent medical assistant for TELLinMedicine, LLC and Dr. Jasper I. Ngomba, MD in North Attleboro, MA.

Practice Context:
- Today's Date: {$todayDateStr} (Date ISO: {$todayIso})
- Clinic Address: {$address}
- Primary Phone: {$phonePrimary}
- In-Clinic Hours: {$clinicHours}
- E-Appointments/Telehealth Hours: {$telehealthHours}
- Sunday Hours: {$sundayHours}
- Available Care Delivery Models: '{$modelInClinic}', '{$modelHome}', '{$modelTelehealth}'.
- Common Reasons for Visit: {$reasonsStr}.

Official Practice Services (Dynamically Configured in Admin Panel):
{$dynamicServicesText}

CONCISE RESPONSE & APPOINTMENT BOOKING PROTOCOL:
1. BREVITY & CONCISENESS (CRITICAL): Keep all responses concise, direct, helpful, and straight to the point.
2. GREETINGS & PLEASANTRIES: Respond warmly and naturally to greetings. Introduce yourself as {$assistantName} in 1 short sentence and ask how you can help.
3. HELPFUL & OPEN RESPONSES: Answer questions concisely across medical, health, practice, and general topics without declining questions. Gently offer to help book an appointment with Dr. Jasper I. Ngomba, MD when relevant.
4. ABSOLUTELY NO ASTERISKS: Never use asterisks or stars (the * or ** symbol) anywhere in your response under any circumstances. Use plain dash bullets (-) for lists with clear line breaks.
5. DYNAMIC CARE MODEL HOURS & RULES:
   - IN-CLINIC VISITS ('{$modelInClinic}') & HOME VISITS ('{$modelHome}'): Follow active clinic working hours: {$clinicHours}. Physical clinic visits and Home Visits are CLOSED on Sundays!
   - E-APPOINTMENTS ('{$modelTelehealth}'): Follow active telehealth working hours: {$telehealthHours}. On Sundays: {$sundayHours}.
   - AGE LIMITS: In-Clinic Visits and E-Appointments are open to patients of ALL ages (no 65+ age limit). Home Visits are reserved exclusively for seniors (Age 65+) or persons with disabilities (only check/mention Home Visit rules if patient explicitly requests a Home Visit).
   - SUNDAY CLOSURE RULE: If a requested date is a Sunday and the user requested an In-Clinic Visit or Home Visit, DO NOT propose or confirm an In-Clinic Visit for Sunday! Inform them that physical clinic visits are closed on Sundays ({$sundayHours}) and ask if they would like to switch to an E-Appointment for Sunday or select a weekday (Mon-Sat) for an In-Clinic Visit.
   - TIME SLOT HOURS: Always verify that the requested time slot falls within the active working hours for the selected care model ({$clinicHours} for In-Clinic/Home Visit; {$telehealthHours} for E-Appointments). If out of bounds, inform the user of the active hours for that care model and ask them to pick a valid time slot.
6. REASON FOR VISIT: Accept any specific reason or custom symptoms described by the patient (including custom reason text) and pass it accurately in the 'reason' parameter.
7. APPOINTMENT BOOKING PROTOCOL: If a patient wants to book an appointment (or ask about availability), ask for the required details in a clean, beautifully formatted bullet list with clear line breaks:

I would be happy to help you book an appointment! Please provide the following details:

- Full Name
- Phone Number
- Email Address
- Patient Age
- Preferred Care Delivery Model ('{$modelInClinic}', '{$modelHome}', or '{$modelTelehealth}')
- Preferred Date (YYYY-MM-DD format or readable date)
- Preferred Time Slot (matching working hours: {$clinicHours} for In-Clinic, {$telehealthHours} for E-Appointments)
- Reason for Visit (any specific or custom reason)
- Disability Status (if Home Visit is requested)

8. IMMEDIATE TOOL EXECUTION: Once the user provides the required details (Name, Phone, Email, Age, Care Model, Date, Time, Reason), call the 'book_appointment' tool IMMEDIATELY! Do NOT generate manual confirmation text or pretend to confirm an out-of-bounds appointment.";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        // Append past conversation history (limit to last 6 messages)
        $trimmedHistory = array_slice($history, -6);
        foreach ($trimmedHistory as $item) {
            if (isset($item['role'], $item['content'])) {
                $messages[] = [
                    'role' => $item['role'] === 'user' ? 'user' : 'assistant',
                    'content' => (string) $item['content']
                ];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // Define OpenAI Tool for function calling
        $tools = [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'book_appointment',
                    'description' => 'Creates a confirmed appointment for a patient in the clinic system and sends email notifications to the doctor team.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'patient_name' => ['type' => 'string', 'description' => 'Full name of the patient'],
                            'patient_phone' => ['type' => 'string', 'description' => 'Phone number of the patient'],
                            'patient_email' => ['type' => 'string', 'description' => 'Email address of the patient'],
                            'patient_age' => ['type' => 'integer', 'description' => 'Age of the patient in years'],
                            'is_disabled' => ['type' => 'boolean', 'description' => 'True if the patient has a disability or mobility limitation'],
                            'appointment_date' => ['type' => 'string', 'description' => 'Appointment date in YYYY-MM-DD format'],
                            'time_slot' => ['type' => 'string', 'description' => 'Time slot, e.g. 10:00 AM or 2:00 PM'],
                            'care_model' => ['type' => 'string', 'description' => "Care model: '{$modelInClinic}', '{$modelHome}', or '{$modelTelehealth}'."],
                            'reason' => ['type' => 'string', 'description' => 'Reason for the appointment (accept any specific or custom reason)'],
                        ],
                        'required' => ['patient_name', 'patient_phone', 'patient_email', 'patient_age', 'appointment_date', 'time_slot', 'care_model'],
                    ]
                ]
            ]
        ];

        if (!empty($apiKey)) {
            try {
                $response = Http::withToken($apiKey)
                    ->timeout(15)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => $messages,
                        'tools' => $tools,
                        'tool_choice' => 'auto',
                        'temperature' => 0.5,
                    ]);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $choice = $responseData['choices'][0]['message'] ?? null;

                    if ($choice) {
                        // Check if OpenAI wants to call book_appointment tool
                        if (!empty($choice['tool_calls'])) {
                            foreach ($choice['tool_calls'] as $toolCall) {
                                if (($toolCall['function']['name'] ?? '') === 'book_appointment') {
                                    $args = json_decode($toolCall['function']['arguments'] ?? '{}', true);
                                    return $this->processAppointmentFromChat($args, $userMessage, $history, $modelTelehealth, $clinicHours, $telehealthHours, $sundayHours);
                                }
                            }
                        }

                        $reply = $choice['content'] ?? null;
                        if (!empty($reply)) {
                            $cleanReply = str_replace('*', '', $reply);
                            return response()->json([
                                'success' => true,
                                'reply' => $cleanReply,
                                'appointment_created' => false,
                            ]);
                        }
                    }
                } else {
                    Log::warn('OpenAI API request returned status: ' . $response->status() . ' - ' . $response->body());
                }
            } catch (\Throwable $e) {
                Log::error('OpenAI Chat API Throwable Error: ' . $e->getMessage());
            }
        }

        // Smart Fallback if API key is missing or call fails
        return $this->generateSmartFallbackResponse($userMessage, $assistantName);
    }

    private function processAppointmentFromChat(array $args, string $userMessage = '', array $history = [], string $modelTelehealth = 'E-Appointments', string $clinicHours = '', string $telehealthHours = '', string $sundayHours = '')
    {
        try {
            $patientName = trim($args['patient_name'] ?? 'Patient');
            $patientPhone = trim($args['patient_phone'] ?? '');
            $patientEmail = trim($args['patient_email'] ?? '');
            $patientAge = isset($args['patient_age']) ? (int)$args['patient_age'] : null;
            $isDisabled = !empty($args['is_disabled']);
            $appointmentDate = trim($args['appointment_date'] ?? date('Y-m-d'));
            $timeSlot = trim($args['time_slot'] ?? '10:00 AM');
            $careModel = trim($args['care_model'] ?? 'In-Clinic');
            $reason = trim($args['reason'] ?? 'Medical Consultation');

            // Sunday check: Physical clinic and home visits are closed on Sundays (E-Appointments only)
            $isSunday = \Carbon\Carbon::parse($appointmentDate)->isSunday();
            $careModelLower = strtolower($careModel);
            $teleSettingLower = strtolower($modelTelehealth ?: '');
            $isTelehealth = str_contains($careModelLower, 'tele')
                || str_contains($careModelLower, 'e-appointment')
                || str_contains($careModelLower, 'e appointment')
                || str_contains($careModelLower, 'eappointment')
                || str_contains($careModelLower, 'virtual')
                || str_contains($careModelLower, 'online')
                || ($teleSettingLower !== '' && str_contains($careModelLower, $teleSettingLower));

            if ($isSunday && !$isTelehealth) {
                // Check if assistant previously prompted the user about Sunday closure
                $lastAssistantMsg = '';
                if (!empty($history) && is_array($history)) {
                    for ($i = count($history) - 1; $i >= 0; $i--) {
                        if (($history[$i]['role'] ?? '') === 'assistant' || ($history[$i]['role'] ?? '') === 'model') {
                            $lastAssistantMsg = strtolower($history[$i]['content'] ?? '');
                            break;
                        }
                    }
                }

                $assistantAskedToSwitch = str_contains($lastAssistantMsg, 'closed on sundays') || 
                                           str_contains($lastAssistantMsg, 'switch to an e-appointment') || 
                                           str_contains($lastAssistantMsg, 'virtual telehealth');

                $recentUserText = strtolower($userMessage);
                $userConfirmedSwitch = str_contains($recentUserText, 'switch') || 
                                       str_contains($recentUserText, 'e-appointment') || 
                                       str_contains($recentUserText, 'e appointment') || 
                                       str_contains($recentUserText, 'virtual') || 
                                       str_contains($recentUserText, 'tele') || 
                                       str_contains($recentUserText, 'yep') || 
                                       str_contains($recentUserText, 'yes') || 
                                       str_contains($recentUserText, 'confirm') || 
                                       str_contains($recentUserText, 'ok') || 
                                       str_contains($recentUserText, 'sure') || 
                                       str_contains($recentUserText, 'same date');

                if ($assistantAskedToSwitch && $userConfirmedSwitch) {
                    $careModel = $modelTelehealth ?: 'E-Appointments';
                    $careModelLower = strtolower($careModel);
                    $isTelehealth = true;
                } else {
                    $sunHoursText = !empty($sundayHours) ? $sundayHours : 'Closed (E-Appointments Only)';
                    return response()->json([
                        'success' => true,
                        'reply' => "The physical clinic and Home Visits are closed on Sundays ({$sunHoursText}). On Sundays, we offer E-Appointments (Virtual Telehealth).\n\nWould you like to switch to an E-Appointment for Sunday, or select a weekday (Mon–Sat) for an In-Clinic Visit?",
                        'appointment_created' => false,
                    ]);
                }
            }

            // Dynamic Time Slot Hours Validation
            try {
                $carbonTime = \Carbon\Carbon::parse($timeSlot);
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
                        $displayHours = !empty($clinicHours) ? $clinicHours : 'Mon - Sat: 10 AM - 2 PM (In-Clinic)';
                        $tHours = !empty($telehealthHours) ? $telehealthHours : 'Mon - Sat: 2 PM - 7 PM (E-Appointments)';
                        return response()->json([
                            'success' => true,
                            'reply' => "In-Clinic Visits and Home Visits are available during active clinic working hours ({$displayHours}).\n\nFor {$timeSlot} care, would you like to book an E-Appointment (available {$tHours}), or select a time slot during clinic hours ({$displayHours}) for your In-Clinic Visit?",
                            'appointment_created' => false,
                        ]);
                    }
                } else {
                    [$startMins, $endMins] = $parseRange($telehealthHours, 840, 1140);
                    if ($totalMins < $startMins || $totalMins > $endMins) {
                        $displayHours = !empty($telehealthHours) ? $telehealthHours : 'Mon - Sat: 2 PM - 7 PM (E-Appointments)';
                        return response()->json([
                            'success' => true,
                            'reply' => "E-Appointments (Virtual Care) are available during practice telehealth hours ({$displayHours}).\n\nWould you like to choose a time slot within telehealth hours, or book an In-Clinic Visit instead?",
                            'appointment_created' => false,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Ignore parsing errors
            }

            // Home Visit Eligibility check
            if (str_contains(strtolower($careModel), 'home')) {
                $ageVal = $patientAge ?? 0;
                if ($ageVal < 65 && !$isDisabled) {
                    return response()->json([
                        'success' => true,
                        'reply' => "Physician Home Visits are exclusively available for seniors aged 65 or older, or individuals with disabilities.\n\nWould you like to book an In-Clinic Visit or E-Appointment instead?",
                        'appointment_created' => false,
                    ]);
                }
            }

            // Format date nicely
            $formattedDate = \Carbon\Carbon::parse($appointmentDate)->format('M d, Y');

            $appointment = Appointment::create([
                'patient_name' => $patientName,
                'patient_phone' => $patientPhone,
                'patient_email' => $patientEmail,
                'patient_age' => $patientAge,
                'is_disabled' => $isDisabled,
                'appointment_date' => $appointmentDate,
                'time_slot' => $timeSlot,
                'care_model' => $careModel,
                'reason' => $reason,
                'status' => 'pending',
            ]);

            // Dispatch notification emails to active recipients in Admin Panel
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
                    Log::error("Failed to send appointment notification email from Chat to {$recipientEmail}: " . $e->getMessage());
                }
            }

            $replyMessage = "Appointment Confirmed!\n\n" .
                "Thank you, {$patientName}. Your {$careModel} appointment request for {$formattedDate} at {$timeSlot} has been successfully booked.\n\n" .
                "An instant email confirmation has been sent to Dr. Ngomba's clinic team. We look forward to seeing you!";

            return response()->json([
                'success' => true,
                'reply' => $replyMessage,
                'appointment_created' => true,
                'appointment' => $appointment,
            ]);
        } catch (\Throwable $e) {
            Log::error('Chat appointment creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => "I captured your booking details, but encountered an error saving the appointment. Please try submitting via our quick calendar booking form or call our office at (774) 643-6261.",
                'appointment_created' => false,
            ]);
        }
    }

    private function generateSmartFallbackResponse($query, $assistantName = 'TELLinCare Assist')
    {
        $q = strtolower($query);

        if (in_array($q, ['hi', 'hello', 'hey', 'hi there', 'hello there']) || str_contains($q, 'how are you') || str_contains($q, 'good morning') || str_contains($q, 'good afternoon')) {
            $reply = "Hello! I am {$assistantName}, Dr. Ngomba's Medical AI Assistant at TELLinMedicine, LLC.\n\nHow can I assist you with your medical care or scheduling an appointment today?";
        } elseif (str_contains($q, 'book') || str_contains($q, 'appointment') || str_contains($q, 'schedule') || str_contains($q, 'visit')) {
            $reply = "I can help you schedule an appointment with Dr. Ngomba.\n\nTo book your visit directly, please provide:\n1. Full Name\n2. Phone Number\n3. Email Address\n4. Preferred Date and Time\n5. Care Delivery Model (In-Clinic, Home Visit, or E-Appointments)\n6. Reason for Visit";
        } elseif (str_contains($q, 'hour') || str_contains($q, 'time') || str_contains($q, 'open')) {
            $reply = "TELLinMedicine Practice Hours:\n\n- In-Clinic Visits: Monday – Saturday (8:00 AM – 12:00 PM)\n- E-Appointments & Virtual Care: Monday – Saturday (12:00 PM – 6:00 PM)\n- Sunday: E-Appointments Only (12:00 PM – 6:00 PM)";
        } elseif (str_contains($q, 'location') || str_contains($q, 'address') || str_contains($q, 'where')) {
            $reply = "Clinic Address:\n380 Elm Street, Suite 1, North Attleboro, MA 02760.\nPhone: (774) 643-6261";
        } else {
            $reply = "Hello! I am {$assistantName}, Dr. Ngomba's Medical AI Assistant at TELLinMedicine, LLC.\n\nHow can I assist you with your health care, questions, or scheduling an appointment today?";
        }

        return response()->json([
            'success' => true,
            'reply' => $reply,
            'appointment_created' => false,
        ]);
    }
}
