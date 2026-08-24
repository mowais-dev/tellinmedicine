<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Primary Meta Tags -->
  <title>@yield('title', $globalSettings['site_title'] ?? 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD | Primary Care, Home Visits & Telehealth')</title>
  <meta name="title" content="@yield('title', $globalSettings['site_title'] ?? 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD')">
  <meta name="description" content="@yield('meta_description', $globalSettings['site_description'] ?? 'TELLinMedicine, LLC - Adult Primary Care, Physician Home Visits, World TeleMedicine, and Travel Vaccines in North Attleboro, MA. Founded by Dr. Jasper Ngomba, MD.')">
  <meta name="keywords" content="TELLinMedicine, Dr Jasper Ngomba MD, Primary Care North Attleboro MA, Physician Home Visits, Telehealth, Travel Vaccines, DOT Physicals, Preventive Medicine">
  <meta name="author" content="Dr. Jasper I. Ngomba, MD">

  <!-- Canonical Link -->
  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Open Graph / WhatsApp / Facebook / LinkedIn Meta Tags -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', $globalSettings['site_title'] ?? 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD')">
  <meta property="og:description" content="@yield('meta_description', $globalSettings['site_description'] ?? 'TELLinMedicine, LLC - Adult Primary Care, Physician Home Visits, World TeleMedicine, and Travel Vaccines in North Attleboro, MA. Founded by Dr. Jasper Ngomba, MD.')">
  <meta property="og:image" content="{{ asset($globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <meta property="og:image:secure_url" content="{{ asset($globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="400">
  <meta property="og:image:height" content="400">
  <meta property="og:site_name" content="TELLinMedicine, LLC">

  <!-- Twitter Card Social Meta Tags -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:url" content="{{ url()->current() }}">
  <meta name="twitter:title" content="@yield('title', $globalSettings['site_title'] ?? 'TELLinMedicine, LLC | Dr. Jasper I. Ngomba, MD')">
  <meta name="twitter:description" content="@yield('meta_description', $globalSettings['site_description'] ?? 'TELLinMedicine, LLC - Adult Primary Care, Physician Home Visits, World TeleMedicine, and Travel Vaccines in North Attleboro, MA. Founded by Dr. Jasper Ngomba, MD.')">
  <meta name="twitter:image" content="{{ asset($globalSettings['logo_path'] ?? 'images/logo.png') }}">

  <!-- Favicon (Dynamic from Admin Uploaded Logo) -->
  <link rel="icon" type="image/png" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">

  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/claymorphism.css') }}">
</head>

<body>

  @include('partials.topbar')

  @include('partials.header')

  @yield('content')

  @include('partials.footer')

  @include('partials.booking-modal')

  @include('partials.concierge-modal')

  @include('partials.chat-widget')

  <!-- Scripts -->
  <script>
    window.practiceHoursConfig = {
      clinicHours: @json($globalSettings['hours_clinic_text'] ?? ''),
      telehealthHours: @json($globalSettings['hours_telehealth_text'] ?? ''),
      sundayHours: @json($globalSettings['hours_sunday_text'] ?? '')
    };
    window.careModelNames = {
      inClinic: @json($globalSettings['booking_model_in_clinic'] ?? ''),
      homeVisit: @json($globalSettings['booking_model_home'] ?? ''),
      telehealth: @json($globalSettings['booking_model_telehealth'] ?? '')
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
