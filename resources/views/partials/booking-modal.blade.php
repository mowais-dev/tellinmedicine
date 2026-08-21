  <!-- Appointment Booking Modal Dialog -->
  <div class="modal-backdrop" id="bookingModal">
    <div class="modal-clay-dialog">

      <div class="modal-header">
        <h3 class="modal-title">{{ $globalSettings['booking_modal_title'] ?? '' }}</h3>
        <button class="modal-close" id="closeModal" aria-label="Close Modal">✕</button>
      </div>

      <form id="bookingForm">
        @csrf

        <label class="form-label" style="margin-bottom: 0.75rem;">{{ $globalSettings['booking_care_label'] ?? '' }}</label>
        <div class="care-option-grid">
          <div class="care-option-card selected" data-value="{{ $globalSettings['booking_model_in_clinic'] ?? 'In-Clinic' }}">
            <div class="care-option-icon">🏥</div>
            <div class="care-option-title">{{ $globalSettings['booking_model_in_clinic'] ?? 'In-Clinic' }}</div>
          </div>
          <div class="care-option-card" data-value="{{ $globalSettings['booking_model_home'] ?? 'Home Visit' }}">
            <div class="care-option-icon">🏠</div>
            <div class="care-option-title">{{ $globalSettings['booking_model_home'] ?? 'Home Visit' }}</div>
          </div>
          <div class="care-option-card" data-value="{{ $globalSettings['booking_model_telehealth'] ?? 'E-Appointments' }}">
            <div class="care-option-icon">💻</div>
            <div class="care-option-title">{{ $globalSettings['booking_model_telehealth'] ?? 'E-Appointments' }}</div>
          </div>
        </div>
        <input type="hidden" id="selectedCareModel" name="care_model" value="In-Clinic">

        <!-- Home Visit Eligibility Section (shown when Home Visit is selected) -->
        <div class="home-visit-eligibility-wrapper" style="display: none; margin-top: 0.85rem; margin-bottom: 0.85rem;">
          <div class="home-visit-notice-box" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 0.75rem 0.9rem; font-size: 0.82rem; color: #0369a1; margin-bottom: 0.75rem; line-height: 1.45;">
            🏠 <strong>Home Visit Criteria:</strong> Physician Home Visits are exclusively available for seniors <strong>(Age 65+)</strong> or <strong>individuals with disabilities</strong>.
          </div>

          <div class="form-group" style="margin-bottom: 0.75rem;">
            <label style="font-size: 0.83rem; cursor: pointer; display: flex; align-items: center; gap: 0.45rem; color: var(--text-dark); font-weight: 600;">
              <input type="checkbox" name="is_disabled" value="1" class="home-visit-disabled-check" style="width: 17px; height: 17px; cursor: pointer; accent-color: var(--brand-blue);">
              Patient has a disability or mobility limitation
            </label>
          </div>

          <div class="home-visit-ineligible-msg" style="display: none; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 10px; padding: 0.75rem 0.9rem; font-size: 0.83rem; color: #be123c; line-height: 1.45;">
            ⚠️ <strong>Notice:</strong> Physician Home Visits are exclusively provided for patients aged 65 or older, or individuals with disabilities. If you do not meet these criteria, please select <strong>In-Clinic Visit</strong> or <strong>E-Appointments</strong>.
          </div>
        </div>

        <div class="standard-booking-fields">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['booking_label_name'] ?? '' }}</label>
              <input type="text" id="patientName" name="patient_name" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_name'] ?? '' }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['booking_label_phone'] ?? '' }}</label>
              <input type="tel" id="patientPhone" name="patient_phone" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_phone'] ?? '' }}" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['booking_label_email'] ?? '' }}</label>
              <input type="email" id="patientEmail" name="patient_email" class="clay-input" placeholder="{{ $globalSettings['booking_placeholder_email'] ?? '' }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Patient Age *</label>
              <input type="number" id="patientAge" name="patient_age" class="clay-input home-visit-age-input" placeholder="e.g. 45" min="1" max="120" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label class="form-label">{{ $globalSettings['booking_label_date'] ?? '' }}</label>
              <input type="date" id="bookDate" name="appointment_date" class="clay-input" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Preferred Time Slot</label>
              <select id="timeSlotSelect" name="time_slot" class="clay-input" required style="cursor: pointer;">
                <!-- Populated by JS based on care model and date -->
              </select>
            </div>
          </div>

          <div class="form-group" style="margin-top: 0.75rem;">
            <label class="form-label">{{ $globalSettings['booking_label_reason'] ?? '' }}</label>
            <select id="bookingReason" name="reason" class="clay-input redirect-option-select reason-select-box" style="cursor: pointer;">
              <option value="">-- Select Reason for Visit --</option>
              @foreach($bookingReasons as $reason)
                <option value="{{ $reason->label }}" data-redirect-url="{{ $reason->redirect_url }}">{{ $reason->label }}</option>
              @endforeach
              @if(!$bookingReasons->contains(function($r){ return strtolower($r->value) === 'other' || str_contains(strtolower($r->label), 'other'); }))
                <option value="other">Other (Please specify)</option>
              @endif
            </select>
            <div class="other-reason-wrapper" style="display: none; margin-top: 0.6rem;">
              <label class="form-label" style="font-size: 0.8rem; color: var(--brand-blue-hover);">Please specify your reason:</label>
              <input type="text" name="other_reason" class="clay-input other-reason-input" placeholder="Type your specific reason for visit here..." style="font-size: 0.88rem;">
            </div>
          </div>

          <button type="submit" id="submitBookingBtn" class="clay-button clay-button-primary" style="width: 100%; margin-top: 1.25rem;">
            {{ $globalSettings['booking_btn_text'] ?? '' }}
          </button>
        </div>

      </form>

    </div>
  </div>
