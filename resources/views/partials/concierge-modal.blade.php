  <!-- Concierge Plan Subscription Inquiry Modal -->
  <div class="modal-backdrop" id="conciergeModal">
    <div class="modal-clay-dialog" style="max-width: 500px; padding: 1.35rem 1.6rem;">

      <div class="modal-header" style="align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
        <div style="flex: 1; min-width: 0;">
          <span class="badge-clay badge-clay-crimson" id="conciergeModalPlanBadge" style="display: inline-block; font-size: 0.75rem; padding: 0.2rem 0.65rem; margin-bottom: 0.25rem;">
            💎 Gold Plan
          </span>
          <h3 class="modal-title" style="margin-top: 0.15rem; font-size: 1.25rem; font-weight: 800; line-height: 1.2;">
            {{ $globalSettings['concierge_modal_title'] ?? 'Concierge Plan Membership Inquiry' }}
          </h3>
          <p style="color: var(--text-medium); font-size: 0.8rem; margin-top: 0.2rem; margin-bottom: 0; line-height: 1.35;">
            {{ $globalSettings['concierge_modal_subtitle'] ?? "Complete your details below and Dr. Ngomba's medical team will contact you directly to confirm your enrollment." }}
          </p>
        </div>
        <button class="modal-close" id="closeConciergeModal" aria-label="Close Concierge Modal">✕</button>
      </div>

      <form id="conciergeSubscriptionForm">
        @csrf
        <input type="hidden" id="conciergeSelectedPlan" name="plan_name" value="Gold Plan">
        <input type="hidden" id="conciergeSelectedPrice" name="plan_price" value="">

        <!-- Selected Plan Summary Card -->
        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 0.55rem 0.85rem; margin-top: 0.4rem; margin-bottom: 0.85rem; display: flex; align-items: center; justify-content: space-between;">
          <div>
            <span style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 700;">Selected Membership Plan</span>
            <div id="conciergePlanDisplayName" style="font-weight: 800; font-size: 0.98rem; color: #0f172a; margin-top: 0.05rem;">
              Gold Plan ($2,000 / year)
            </div>
          </div>
          <span style="font-size: 1.4rem;">💎</span>
        </div>

        <div class="form-group mb-2">
          <label class="form-label" for="conciergePatientName" style="font-size: 0.82rem; margin-bottom: 0.2rem;">Full Name <span style="color: #ef4444;">*</span></label>
          <input type="text" id="conciergePatientName" name="patient_name" class="clay-input" style="padding: 0.5rem 0.85rem; font-size: 0.88rem;" placeholder="e.g. John Doe" required>
        </div>

        <div class="grid-2 mb-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
          <div class="form-group mb-0">
            <label class="form-label" for="conciergePatientPhone" style="font-size: 0.82rem; margin-bottom: 0.2rem;">Phone Number <span style="color: #ef4444;">*</span></label>
            <input type="tel" id="conciergePatientPhone" name="patient_phone" class="clay-input" style="padding: 0.5rem 0.85rem; font-size: 0.88rem;" placeholder="e.g. (555) 000-0000" required>
          </div>
          <div class="form-group mb-0">
            <label class="form-label" for="conciergePatientEmail" style="font-size: 0.82rem; margin-bottom: 0.2rem;">Email Address <span style="color: #ef4444;">*</span></label>
            <input type="email" id="conciergePatientEmail" name="patient_email" class="clay-input" style="padding: 0.5rem 0.85rem; font-size: 0.88rem;" placeholder="e.g. john@example.com" required>
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label" for="conciergePatientNotes" style="font-size: 0.82rem; margin-bottom: 0.2rem;">Additional Questions or Notes <span style="color: var(--text-muted); font-weight: 400;">(Optional)</span></label>
          <textarea id="conciergePatientNotes" name="patient_notes" class="clay-input" style="min-height: 52px; height: 55px; padding: 0.45rem 0.85rem; font-size: 0.85rem; resize: vertical;" placeholder="e.g. Preferred call time, family member count, or specific care questions..."></textarea>
        </div>

        <button type="submit" id="conciergeSubmitBtn" class="clay-button clay-button-primary" style="width: 100%; justify-content: center; font-size: 0.92rem; padding: 0.65rem 1.25rem;">
          {{ $globalSettings['concierge_modal_btn_text'] ?? '📩 Submit Membership Inquiry' }}
        </button>
      </form>

    </div>
  </div>
