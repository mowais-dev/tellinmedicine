<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Appointment Request - {{ $brandName }}</title>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
      color: #334155;
      width: 100% !important;
    }
    .wrapper {
      width: 100%;
      background-color: #f8fafc;
      padding: 30px 10px;
    }
    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 50, 40, 0.08);
      border: 1px solid #e2e8f0;
      word-break: break-word;
      overflow-wrap: break-word;
    }
    .top-accent-bar {
      height: 5px;
      background: linear-gradient(90deg, #0B5382 0%, #1A84C5 60%, #ED174F 100%);
    }
    .email-header {
      background: #edf5fc;
      padding: 24px 28px;
      border-bottom: 1px solid #e2e8f0;
    }
    .header-branding-table {
      width: 100%;
      border-collapse: collapse;
    }
    .header-logo-cell {
      width: 58px;
      vertical-align: middle;
      padding-right: 14px;
    }
    .header-logo-cell img {
      max-height: 54px;
      width: auto;
      display: block;
    }
    .header-text-cell {
      vertical-align: middle;
    }
    .brand-main-heading {
      margin: 0;
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.5px;
      line-height: 1.1;
    }
    .brand-prefix {
      color: #0B5382;
    }
    .brand-accent {
      color: #ED174F;
    }
    .brand-sub-heading {
      margin: 4px 0 0 0;
      font-size: 11px;
      font-weight: 800;
      color: #1e293b;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }
    .email-body {
      padding: 28px 28px;
    }
    .status-badge {
      display: inline-block;
      background: #e0f2fe;
      color: #0369a1;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 5px 12px;
      border-radius: 20px;
      margin-bottom: 18px;
    }
    .greeting-title {
      font-size: 16px;
      font-weight: 700;
      color: #0f172a;
      margin-top: 0;
      margin-bottom: 6px;
    }
    .intro-text {
      font-size: 13px;
      line-height: 1.5;
      color: #475569;
      margin-bottom: 20px;
    }
    .info-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 20px;
      word-break: break-word;
      overflow-wrap: break-word;
    }
    .info-card-header {
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: #64748b;
      margin-bottom: 12px;
      border-bottom: 1px solid #e2e8f0;
      padding-bottom: 6px;
    }
    .detail-row {
      display: table;
      width: 100%;
      margin-bottom: 10px;
      table-layout: fixed;
    }
    .detail-row:last-child {
      margin-bottom: 0;
    }
    .detail-label {
      display: table-cell;
      width: 36%;
      font-size: 12px;
      color: #64748b;
      font-weight: 600;
      vertical-align: top;
      padding-right: 8px;
      word-break: break-word;
    }
    .detail-value {
      display: table-cell;
      width: 64%;
      font-size: 13px;
      color: #0f172a;
      font-weight: 700;
      vertical-align: top;
      word-break: break-word;
      overflow-wrap: break-word;
    }
    .detail-value a {
      word-break: break-all;
      word-break: break-word;
    }
    .care-tag {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 800;
    }
    .care-clinic { background: #dcfce7; color: #15803d; }
    .care-home { background: #fee2e2; color: #b91c1c; }
    .care-telehealth { background: #f3e8ff; color: #7e22ce; }
    
    .quick-cta-box {
      margin-top: 20px;
      padding: 14px 16px;
      background: #f0f9ff;
      border-left: 4px solid #1A84C5;
      border-radius: 8px;
    }
    .quick-cta-box p {
      margin: 0 0 8px 0;
      font-size: 12px;
      color: #0f172a;
      line-height: 1.4;
    }
    .btn-call {
      display: inline-block;
      background: #1A84C5;
      color: #ffffff !important;
      text-decoration: none;
      font-size: 12px;
      font-weight: 700;
      padding: 7px 14px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(26, 132, 197, 0.3);
    }
    .email-footer {
      background-color: #f1f5f9;
      padding: 18px 24px;
      text-align: center;
      font-size: 11px;
      color: #64748b;
      border-top: 1px solid #e2e8f0;
      line-height: 1.5;
    }

    @media only screen and (max-width: 520px) {
      .wrapper {
        padding: 12px 6px !important;
      }
      .email-header {
        padding: 18px 16px !important;
      }
      .email-body {
        padding: 20px 14px !important;
      }
      .email-footer {
        padding: 16px 14px !important;
      }
      .brand-main-heading {
        font-size: 19px !important;
      }
      .brand-sub-heading {
        font-size: 10px !important;
      }
      .greeting-title {
        font-size: 15px !important;
      }
      .intro-text {
        font-size: 12px !important;
      }
      .info-card {
        padding: 12px !important;
      }
      .detail-row {
        display: block !important;
        width: 100% !important;
        margin-bottom: 12px !important;
      }
      .detail-label {
        display: block !important;
        width: 100% !important;
        font-size: 11px !important;
        margin-bottom: 2px !important;
        color: #64748b !important;
      }
      .detail-value {
        display: block !important;
        width: 100% !important;
        font-size: 12px !important;
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
      }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="email-container">

      <!-- Top Bar Accent -->
      <div class="top-accent-bar"></div>

      <!-- Header -->
      <div class="email-header">
        <table class="header-branding-table" role="presentation">
          <tr>
            @if(!empty($logoPath) && file_exists($logoPath))
              <td class="header-logo-cell">
                <img src="{{ $message->embed($logoPath) }}" alt="{{ $brandName }}">
              </td>
            @endif
            <td class="header-text-cell">
              <h1 class="brand-main-heading">
                <span class="brand-prefix">{{ $brandPrefix }}</span><span class="brand-accent">{{ $brandAccent }}</span>
              </h1>
              <p class="brand-sub-heading">{{ $brandSub }}</p>
            </td>
          </tr>
        </table>
      </div>

      <!-- Body -->
      <div class="email-body">
        <span class="status-badge">📅 New Patient Booking Request</span>

        <h2 class="greeting-title">Hello {{ $doctorName }},</h2>
        <p class="intro-text">
          A new patient appointment request has been received through your online booking platform. Below are the complete patient and visit details:
        </p>

        <!-- Patient Info Card -->
        <div class="info-card">
          <div class="info-card-header">👤 Patient Information</div>
          <div class="detail-row">
            <div class="detail-label">Patient Name</div>
            <div class="detail-value">{{ $appointment->patient_name }}</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Phone Number</div>
            <div class="detail-value">
              <a href="tel:{{ $appointment->patient_phone }}" style="color: #1A84C5; text-decoration: none;">
                {{ $appointment->patient_phone }}
              </a>
            </div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Email Address</div>
            <div class="detail-value">
              <a href="mailto:{{ $appointment->patient_email }}" style="color: #1A84C5; text-decoration: none;">
                {{ $appointment->patient_email }}
              </a>
            </div>
          </div>
          @if(!empty($appointment->patient_age))
            <div class="detail-row">
              <div class="detail-label">Patient Age</div>
              <div class="detail-value">{{ $appointment->patient_age }} years old</div>
            </div>
          @endif
          @if($appointment->is_disabled)
            <div class="detail-row">
              <div class="detail-label">Disability Status</div>
              <div class="detail-value" style="color: #7e22ce;">♿ Mobility / Disability Care Needed</div>
            </div>
          @endif
        </div>

        <!-- Appointment Details Card -->
        <div class="info-card">
          <div class="info-card-header">🏥 Appointment Details</div>
          <div class="detail-row">
            <div class="detail-label">Care Model</div>
            <div class="detail-value">
              @if(str_contains(strtolower($appointment->care_model), 'clinic'))
                <span class="care-tag care-clinic">🏥 {{ $appointment->care_model }}</span>
              @elseif(str_contains(strtolower($appointment->care_model), 'home'))
                <span class="care-tag care-home">🏠 {{ $appointment->care_model }}</span>
              @else
                <span class="care-tag care-telehealth">💻 {{ $appointment->care_model }}</span>
              @endif
            </div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Requested Date</div>
            <div class="detail-value" style="color: #1A84C5;">
              {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}
            </div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Time Slot</div>
            <div class="detail-value">⏰ {{ $appointment->time_slot }}</div>
          </div>
          @if(!empty($appointment->reason))
            <div class="detail-row">
              <div class="detail-label">Reason for Visit</div>
              <div class="detail-value" style="font-weight: normal; color: #334155;">
                {{ $appointment->reason }}
              </div>
            </div>
          @endif
          <div class="detail-row">
            <div class="detail-label">Submitted At</div>
            <div class="detail-value" style="font-weight: normal; font-size: 13px; color: #64748b;">
              {{ $appointment->created_at->format('M d, Y h:i A') }}
            </div>
          </div>
        </div>

        <!-- Action Notice -->
        <div class="quick-cta-box">
          <p>
            <strong>💡 Recommended Action:</strong> Please contact the patient to confirm their scheduled appointment slot.
          </p>
          <a href="tel:{{ $appointment->patient_phone }}" class="btn-call">
            📞 Call Patient Now
          </a>
        </div>
      </div>

      <!-- Footer -->
      <div class="email-footer">
        <p style="margin: 0 0 4px 0;"><strong><span style="color: #0B5382;">{{ $brandPrefix }}</span><span style="color: #ED174F;">{{ $brandAccent }}</span></strong></p>
        <p style="margin: 0 0 6px 0;">{{ $address }}</p>
        <p style="margin: 0; color: #94a3b8;">{{ $copyrightText }}</p>
      </div>

    </div>
  </div>
</body>
</html>
