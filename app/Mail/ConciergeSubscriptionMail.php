<?php

namespace App\Mail;

use App\Models\DoctorProfile;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConciergeSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $globalSettings = Setting::allAsArray();

        $rawLogo = $globalSettings['logo_path'] ?? 'images/logo.png';
        $cleanPath = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rawLogo), DIRECTORY_SEPARATOR);
        $fullPath = public_path($cleanPath);

        $logoPath = file_exists($fullPath) ? $fullPath : (file_exists(public_path('images/logo.png')) ? public_path('images/logo.png') : null);

        $brandPrefix = $globalSettings['brand_name'] ?? 'TELLin';
        $brandAccent = $globalSettings['brand_accent'] ?? 'Medicine';
        $brandSub = $globalSettings['brand_sub_tagline'] ?? 'PRIMARY CARE & TELEHEALTH';

        $brandSubText = trim($globalSettings['brand_sub'] ?? 'LLC');
        $brandName = trim($brandPrefix . $brandAccent) . ($brandSubText ? ', ' . $brandSubText : '');

        $doctor = DoctorProfile::first();
        $docRawName = $doctor->name ?? 'Dr. Jasper I. Ngomba, MD';
        $cleanDoctorName = trim(str_replace(['Meet ', 'Meet'], '', $docRawName));
        if (!str_starts_with($cleanDoctorName, 'Dr.')) {
            $cleanDoctorName = 'Dr. ' . $cleanDoctorName;
        }
        $doctorName = $cleanDoctorName;

        $address = $globalSettings['address'] ?? '380 Elm Street Suite 1, North Attleboro, MA 02760';
        $copyrightText = $globalSettings['copyright_text'] ?? ('© ' . date('Y') . ' ' . $brandName . '. All rights reserved.');

        $planName = $this->details['plan_name'] ?? 'Concierge Plan';
        $patientName = $this->details['patient_name'] ?? 'Patient';

        return $this->subject('💎 New Concierge Membership Inquiry: ' . $patientName . ' (' . $planName . ')')
                    ->view('emails.concierge_subscription')
                    ->with([
                        'details' => $this->details,
                        'globalSettings' => $globalSettings,
                        'logoPath' => $logoPath,
                        'brandPrefix' => $brandPrefix,
                        'brandAccent' => $brandAccent,
                        'brandSub' => $brandSub,
                        'brandName' => $brandName,
                        'doctorName' => $doctorName,
                        'address' => $address,
                        'copyrightText' => $copyrightText,
                    ]);
    }
}
