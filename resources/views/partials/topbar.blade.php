  <!-- Top Contact Header Bar with Smooth Infinite Marquee -->
  <div class="header-topbar" title="Hover to pause marquee">
    <div class="topbar-marquee-track">
      <!-- Set 1 -->
      <div class="topbar-item">📍 <span>{{ $globalSettings['address'] }}</span></div>
      <div class="topbar-item">📞 <a href="tel:{{ preg_replace('/[^0-9]/', '', $globalSettings['phone_primary']) }}">{{ $globalSettings['phone_primary'] }}</a></div>
      <div class="topbar-item">📱 <a href="tel:{{ preg_replace('/[^0-9]/', '', $globalSettings['phone_secondary']) }}">{{ $globalSettings['phone_secondary'] }}</a></div>
      <div class="topbar-item">✉️ <a href="mailto:{{ $globalSettings['email'] }}">{{ $globalSettings['email'] }}</a></div>
      <div class="topbar-item">🏥 <span>{{ $globalSettings['affiliation'] }}</span></div>
      <div class="topbar-item">⏰ <span>{{ $globalSettings['hours_summary'] }}</span></div>
      <div class="topbar-item">✨ <span>{{ $globalSettings['slogan'] }}</span></div>

      <!-- Set 2 (Duplicate for Seamless Loop) -->
      <div class="topbar-item">📍 <span>{{ $globalSettings['address'] }}</span></div>
      <div class="topbar-item">📞 <a href="tel:{{ preg_replace('/[^0-9]/', '', $globalSettings['phone_primary']) }}">{{ $globalSettings['phone_primary'] }}</a></div>
      <div class="topbar-item">📱 <a href="tel:{{ preg_replace('/[^0-9]/', '', $globalSettings['phone_secondary']) }}">{{ $globalSettings['phone_secondary'] }}</a></div>
      <div class="topbar-item">✉️ <a href="mailto:{{ $globalSettings['email'] }}">{{ $globalSettings['email'] }}</a></div>
      <div class="topbar-item">🏥 <span>{{ $globalSettings['affiliation'] }}</span></div>
      <div class="topbar-item">⏰ <span>In-Clinic: Mon-Sat 8 AM-12 PM | E-Appointments: Mon-Sat 12 PM-6 PM</span></div>
      <div class="topbar-item">✨ <span>{{ $globalSettings['slogan'] }}</span></div>
    </div>
  </div>
