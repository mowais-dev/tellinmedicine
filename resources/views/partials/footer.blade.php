  <!-- Footer -->
  <footer class="footer-section">
    <div class="container">
      <div class="footer-grid">

        <div>
          <div class="brand-logo" style="margin-bottom: 1.25rem;">
            <img src="{{ asset($globalSettings['logo_path']) }}" alt="TELLinMedicine Logo">
            <div class="brand-text">
              <span class="brand-title">{{ $globalSettings['brand_name'] ?? '' }}<span class="brand-title-accent">{{ $globalSettings['brand_accent'] ?? '' }}</span></span>
              <span class="brand-sub">{{ $globalSettings['brand_sub'] }}</span>
            </div>
          </div>
          <p style="color: var(--text-medium); font-size: 0.95rem; margin-bottom: 1.5rem;">
            {{ $globalSettings['footer_description'] }}
          </p>
          <div class="badge-clay" style="font-size: 0.5rem;">
            {{ trim($globalSettings['slogan'], '"') }}
          </div>
        </div>

        <div>
          <h4 style="font-size: 1.1rem; margin-bottom: 1.25rem;">{{ $globalSettings['footer_col1_header'] }}</h4>
          <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.65rem; color: var(--text-medium);">
            @foreach($navItems as $nav)
              @if(!$nav->is_cta)
                <li><a href="{{ str_starts_with($nav->url, '/') ? url($nav->url) : $nav->url }}">{{ $nav->label }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>

        <div>
          <h4 style="font-size: 1.1rem; margin-bottom: 1.25rem;">{{ $globalSettings['footer_col2_header'] }}</h4>
          <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.65rem; color: var(--text-medium);">
            @foreach($footerServices as $srv)
              <li><a href="{{ url('/#services') }}">{{ $srv->title }}</a></li>
            @endforeach
          </ul>
        </div>

        <div>
          <h4 style="font-size: 1.1rem; margin-bottom: 1.25rem;">{{ $globalSettings['footer_col3_header'] }}</h4>
          <p style="color: var(--text-medium); font-size: 0.9rem; margin-bottom: 1.25rem;">
            {{ $globalSettings['footer_portal_text'] }}
          </p>
          @if(!empty($globalSettings['portal_button_url']))
            <a href="{{ $globalSettings['portal_button_url'] }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-coral" style="text-decoration: none; text-align: center; display: inline-block;">
              {{ $globalSettings['portal_button_text'] }}
            </a>
          @else
            <button class="clay-button clay-button-coral js-open-booking" data-care-model="In-Clinic">
              {{ $globalSettings['portal_button_text'] }}
            </button>
          @endif
        </div>

      </div>

      <div class="footer-bottom">
        <p>{{ $globalSettings['copyright_text'] }}</p>
      </div>
    </div>
  </footer>
