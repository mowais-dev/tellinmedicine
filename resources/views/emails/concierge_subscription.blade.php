<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Concierge Plan Inquiry - {{ $brandName }}</title>
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
      background: #fff1f2;
      color: #be123c;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 5px 12px;
      border-radius: 20px;
      margin-bottom: 18px;
      border: 1px solid #fecdd3;
    }
    .greeting-title {
      font-size: 18px;
      font-weight: 800;
      color: #0f172a;
      margin-top: 0;
      margin-bottom: 6px;
    }
    .greeting-subtitle {
      font-size: 13px;
      color: #64748b;
      margin-top: 0;
      margin-bottom: 22px;
      line-height: 1.5;
    }
    .plan-card-box {
      background: linear-gradient(135deg, #0B5382 0%, #1A84C5 100%);
      border-radius: 12px;
      padding: 20px;
      color: #ffffff;
      margin-bottom: 24px;
    }
    .plan-card-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #bae6fd;
      margin-bottom: 4px;
    }
    .plan-card-name {
      font-size: 24px;
      font-weight: 800;
      margin: 0;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
    }
    .data-table td {
      padding: 12px 14px;
      border-bottom: 1px solid #f1f5f9;
      font-size: 13px;
    }
    .data-table tr:last-child td {
      border-bottom: none;
    }
    .label-col {
      font-weight: 700;
      color: #475569;
      width: 35%;
      background-color: #f8fafc;
    }
    .value-col {
      color: #0f172a;
      font-weight: 600;
    }
    .email-footer {
      background: #f8fafc;
      padding: 20px 28px;
      border-top: 1px solid #e2e8f0;
      font-size: 12px;
      color: #64748b;
      line-height: 1.5;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="email-container">
      <div class="top-accent-bar"></div>
      
      <!-- Email Header -->
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

      <!-- Email Body -->
      <div class="email-body">
        @php
          $rawPlanName = $details['plan_name'] ?? 'Concierge Plan';
          $planLower = strtolower($rawPlanName);

          // Dynamic Price Lookup: Check passed details first, fallback to global settings
          $rawPrice = $details['plan_price'] ?? null;
          if (empty($rawPrice)) {
              if (str_contains($planLower, 'gold')) {
                  $priceVal = $globalSettings['concierge_gold_price'] ?? '$2,000';
                  $periodVal = $globalSettings['concierge_gold_period'] ?? '/ year';
                  $rawPrice = trim($priceVal . ' ' . $periodVal);
              } elseif (str_contains($planLower, 'platinum')) {
                  $priceVal = $globalSettings['concierge_platinum_price'] ?? '$2,500';
                  $periodVal = $globalSettings['concierge_platinum_period'] ?? '/ year';
                  $rawPrice = trim($priceVal . ' ' . $periodVal);
              } elseif (str_contains($planLower, 'diamond')) {
                  $priceVal = $globalSettings['concierge_diamond_price'] ?? '$3,000';
                  $periodVal = $globalSettings['concierge_diamond_period'] ?? '/ year';
                  $rawPrice = trim($priceVal . ' ' . $periodVal);
              }
          }

          // User-requested color mapping:
          // Platinum = RED, Diamond = BLUE, Gold = GOLDEN AMBER
          if (str_contains($planLower, 'gold')) {
              $boxBg = 'linear-gradient(135deg, #b45309 0%, #d97706 100%)';
              $boxBorder = '1px solid #f59e0b';
              $boxTitleColor = '#fef3c7';
              $badgeBg = '#fef3c7';
              $badgeColor = '#92400e';
              $badgeBorder = '#fde68a';
              $planIcon = '🏆';
          } elseif (str_contains($planLower, 'platinum')) {
              // Platinum Plan -> Crimson Red
              $boxBg = 'linear-gradient(135deg, #ED174F 0%, #be123c 100%)';
              $boxBorder = '1px solid #f43f5e';
              $boxTitleColor = '#ffe4e6';
              $badgeBg = '#ffe4e6';
              $badgeColor = '#be123c';
              $badgeBorder = '#fecdd3';
              $planIcon = '🔥';
          } elseif (str_contains($planLower, 'diamond')) {
              // Diamond Plan -> Deep Blue
              $boxBg = 'linear-gradient(135deg, #0B5382 0%, #1A84C5 100%)';
              $boxBorder = '1px solid #38bdf8';
              $boxTitleColor = '#bae6fd';
              $badgeBg = '#e0f2fe';
              $badgeColor = '#0369a1';
              $badgeBorder = '#bae6fd';
              $planIcon = '💎';
          } else {
              $boxBg = 'linear-gradient(135deg, #0B5382 0%, #1A84C5 100%)';
              $boxBorder = '1px solid #38bdf8';
              $boxTitleColor = '#bae6fd';
              $badgeBg = '#fff1f2';
              $badgeColor = '#be123c';
              $badgeBorder = '#fecdd3';
              $planIcon = '💎';
          }
        @endphp

        <div class="status-badge" style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; border-color: {{ $badgeBorder }};">
          {{ $planIcon }} VIP CONCIERGE PLAN INQUIRY
        </div>
        <h2 class="greeting-title">Hello {{ $doctorName }},</h2>
        <p class="greeting-subtitle">A prospective patient has submitted an inquiry to subscribe to a Concierge Medicine Plan.</p>

        <!-- Selected Plan Box with Dynamic Colors and Price -->
        <div class="plan-card-box" style="background: {{ $boxBg }}; border: {{ $boxBorder }}; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12); padding: 20px; border-radius: 12px; margin-bottom: 24px;">
          <table role="presentation" style="width: 100%; border-collapse: collapse;">
            <tr>
              <td style="padding: 0;">
                <div class="plan-card-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: {{ $boxTitleColor }}; margin-bottom: 4px;">
                  Requested Membership Tier
                </div>
                <div class="plan-card-name" style="font-size: 22px; font-weight: 800; color: #ffffff; margin: 0;">
                  {{ $rawPlanName }}
                </div>
              </td>
              @if(!empty($rawPrice))
                <td style="text-align: right; vertical-align: middle; padding: 0;">
                  <span style="font-size: 14px; font-weight: 800; background: rgba(255, 255, 255, 0.22); color: #ffffff; padding: 6px 14px; border-radius: 20px; display: inline-block; white-space: nowrap; border: 1px solid rgba(255, 255, 255, 0.3);">
                    {{ $rawPrice }}
                  </span>
                </td>
              @endif
            </tr>
          </table>
        </div>

        <!-- Details Table -->
        <table class="data-table" role="presentation">
          <tr>
            <td class="label-col">Selected Plan</td>
            <td class="value-col" style="font-weight: 800; color: #0f172a;">
              {{ $rawPlanName }} @if(!empty($rawPrice))<span style="color: #64748b; font-weight: 600;">({{ $rawPrice }})</span>@endif
            </td>
          </tr>
          <tr>
            <td class="label-col">Patient Name</td>
            <td class="value-col">{{ $details['patient_name'] }}</td>
          </tr>
          <tr>
            <td class="label-col">Phone Number</td>
            <td class="value-col">
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $details['patient_phone']) }}" style="color: #1A84C5; text-decoration: none;">
                {{ $details['patient_phone'] }}
              </a>
            </td>
          </tr>
          <tr>
            <td class="label-col">Email Address</td>
            <td class="value-col">
              <a href="mailto:{{ $details['patient_email'] }}" style="color: #1A84C5; text-decoration: none;">
                {{ $details['patient_email'] }}
              </a>
            </td>
          </tr>
          @if(!empty($details['patient_notes']))
          <tr>
            <td class="label-col">Notes / Questions</td>
            <td class="value-col">{{ $details['patient_notes'] }}</td>
          </tr>
          @endif
          <tr>
            <td class="label-col">Submitted On</td>
            <td class="value-col">{{ $details['submitted_at'] }}</td>
          </tr>
        </table>
      </div>

      <!-- Email Footer -->
      <div class="email-footer">
        <strong>{{ $brandName }}</strong><br>
        {{ $address }}<br>
        {{ $copyrightText }}
      </div>
    </div>
  </div>
</body>
</html>
