  <!-- Main Navigation Header -->
  <header class="main-header">
    <div class="container navbar">
      <a href="{{ Request::is('/') || Request::is('index.html') ? '#hero' : url('/') }}" class="brand-logo">
        <img src="{{ asset($globalSettings['logo_path']) }}" alt="TELLinMedicine LLC Logo">
        <div class="brand-text">
          <span class="brand-title">{{ $globalSettings['brand_name'] ?? '' }}<span class="brand-title-accent">{{ $globalSettings['brand_accent'] ?? '' }}</span></span>
          <span class="brand-sub">{{ $globalSettings['brand_sub'] ?? '' }}</span>
        </div>
      </a>

      <ul class="nav-menu">
        @foreach($navItems as $item)
          @if(!$item->is_cta)
            <li>
              <a href="{{ str_starts_with($item->url, '/') ? url($item->url) : $item->url }}" 
                 class="nav-link {{ (Request::is(ltrim($item->url, '/')) || ($item->url === '/#hero' && (Request::is('/') || Request::is('index.html')))) ? 'active' : '' }}">
                {{ $item->label }}
              </a>
            </li>
          @else
            <li>
              @if(!empty($item->url) && $item->url !== '#')
                <a href="{{ str_starts_with($item->url, '/') ? url($item->url) : $item->url }}" target="_blank" rel="noopener noreferrer" class="clay-button clay-button-primary" style="text-decoration: none; text-align: center; display: inline-block;">
                  {{ $item->label }}
                </a>
              @else
                <button class="clay-button clay-button-primary js-open-booking" data-care-model="{{ $item->care_model ?? 'In-Clinic' }}">
                  {{ $item->label }}
                </button>
              @endif
            </li>
          @endif
        @endforeach
      </ul>

      <button class="mobile-toggle" aria-label="Toggle Navigation">
        ☰
      </button>
    </div>
  </header>
