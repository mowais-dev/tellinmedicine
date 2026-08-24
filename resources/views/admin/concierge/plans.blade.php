@extends('admin.layouts.admin')

@section('title', 'Concierge Medicine - Membership Tiers')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Concierge Medicine</span> <span class="separator">/</span> <span>Membership Tiers</span>
@endsection
@section('page_title', 'Concierge Membership Tiers (Gold, Platinum, Diamond)')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-layer-group"></i>
  <p>Manage Gold, Platinum, and Diamond membership tier pricing, features (enter one feature per line), spouse discounts, and payment terms.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
  @csrf

  <!-- Section Header -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Section Header & Titles</h3>
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Badge Pill Label</label>
        <input type="text" name="concierge_plans_badge" class="form-control" value="{{ $settings['concierge_plans_badge'] ?? 'Concierge Membership Tiers' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Main Section Heading</label>
        <input type="text" name="concierge_plans_title" class="form-control" value="{{ $settings['concierge_plans_title'] ?? 'Comprehensive Annual Healthcare Plans' }}">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Subheading Description</label>
      <input type="text" name="concierge_plans_subtitle" class="form-control" value="{{ $settings['concierge_plans_subtitle'] ?? 'Select the membership tier tailored to your lifestyle and clinical needs.' }}">
    </div>
  </div>

  <!-- Plans Grid (3 Cards) -->
  <div class="grid-3 mb-4">
    <!-- Gold Plan -->
    <div class="card">
      <div class="card-header">
        <h3>Gold Tier Plan</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Tier Badge Label</label>
        <input type="text" name="concierge_gold_badge" class="form-control" value="{{ $settings['concierge_gold_badge'] ?? 'Gold Tier' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Plan Name</label>
        <input type="text" name="concierge_gold_name" class="form-control" value="{{ $settings['concierge_gold_name'] ?? 'Gold Plan' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_gold_price" class="form-control" value="{{ $settings['concierge_gold_price'] ?? '$2,000' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Period Suffix</label>
        <input type="text" name="concierge_gold_period" class="form-control" value="{{ $settings['concierge_gold_period'] ?? '/ year' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Includes Line</label>
        <input type="text" name="concierge_gold_includes" class="form-control" value="{{ $settings['concierge_gold_includes'] ?? 'Includes Yearly Physical Exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Features List (Type 1 Feature Per Line)</label>
        <textarea name="concierge_gold_features" class="form-control" style="min-height: 180px;" placeholder="🩺 Covers Primary Care: 10 visits to office per year&#10;⚡ Direct Access to MD/Provider&#10;📱 5 eTeleMedicine Mobile/Desktop Video Consultations">{{ $settings['concierge_gold_features'] ?? "🩺 Covers Primary Care: 10 visits to office per year\n⚡ Direct Access to MD/Provider\n📱 5 eTeleMedicine Mobile/Desktop Video Consultations\n✈️ Travel Medicine & Advisory\n🌍 Global Network: Assist with referral to Provider when you travel" }}</textarea>
        <small style="color: var(--text-muted); font-size: 0.78rem;">Simply type one bullet point per line. Emojis at the start of a line will be styled automatically.</small>
      </div>
      <div class="form-group">
        <label class="form-label">Spouse Discount Note</label>
        <input type="text" name="concierge_gold_spouse_discount" class="form-control" value="{{ $settings['concierge_gold_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Button Label</label>
        <input type="text" name="concierge_gold_btn_text" class="form-control" value="{{ $settings['concierge_gold_btn_text'] ?? 'Select Gold Plan' }}">
      </div>
    </div>

    <!-- Platinum Plan -->
    <div class="card">
      <div class="card-header">
        <h3>Platinum Tier Plan (Featured)</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Popular Ribbon Text</label>
        <input type="text" name="concierge_platinum_ribbon" class="form-control" value="{{ $settings['concierge_platinum_ribbon'] ?? '🔥 MOST POPULAR' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Tier Badge Label</label>
        <input type="text" name="concierge_platinum_badge" class="form-control" value="{{ $settings['concierge_platinum_badge'] ?? 'Platinum Tier' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Plan Name</label>
        <input type="text" name="concierge_platinum_name" class="form-control" value="{{ $settings['concierge_platinum_name'] ?? 'Platinum Plan' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_platinum_price" class="form-control" value="{{ $settings['concierge_platinum_price'] ?? '$2,500' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Period Suffix</label>
        <input type="text" name="concierge_platinum_period" class="form-control" value="{{ $settings['concierge_platinum_period'] ?? '/ year' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Includes Line</label>
        <input type="text" name="concierge_platinum_includes" class="form-control" value="{{ $settings['concierge_platinum_includes'] ?? 'Includes Yearly Physical Exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Features List (Type 1 Feature Per Line)</label>
        <textarea name="concierge_platinum_features" class="form-control" style="min-height: 180px;" placeholder="🩺 Covers Primary Care: 12 visits to office & 1 Doctor Home Visit&#10;⚡ Direct Access to MD/Provider">{{ $settings['concierge_platinum_features'] ?? "🩺 Covers Primary Care: 12 visits to office & request 1 \"Doctor in the house visit\" per year\n⚡ Direct Access to MD/Provider\n📱 10 eTeleMedicine Mobile/Desktop Video Consultations\n✈️ Travel Medicine & Advisory\n🌍 Global Network: Assist with referral to Provider when you travel" }}</textarea>
        <small style="color: var(--text-muted); font-size: 0.78rem;">Simply type one bullet point per line. Emojis at the start of a line will be styled automatically.</small>
      </div>
      <div class="form-group">
        <label class="form-label">Spouse Discount Note</label>
        <input type="text" name="concierge_platinum_spouse_discount" class="form-control" value="{{ $settings['concierge_platinum_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Button Label</label>
        <input type="text" name="concierge_platinum_btn_text" class="form-control" value="{{ $settings['concierge_platinum_btn_text'] ?? 'Select Platinum Plan' }}">
      </div>
    </div>

    <!-- Diamond Plan -->
    <div class="card">
      <div class="card-header">
        <h3>Diamond Tier Plan</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Tier Badge Label</label>
        <input type="text" name="concierge_diamond_badge" class="form-control" value="{{ $settings['concierge_diamond_badge'] ?? 'Diamond VIP' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Plan Name</label>
        <input type="text" name="concierge_diamond_name" class="form-control" value="{{ $settings['concierge_diamond_name'] ?? 'Diamond Plan' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_diamond_price" class="form-control" value="{{ $settings['concierge_diamond_price'] ?? '$3,000' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Period Suffix</label>
        <input type="text" name="concierge_diamond_period" class="form-control" value="{{ $settings['concierge_diamond_period'] ?? '/ year' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Includes Line</label>
        <input type="text" name="concierge_diamond_includes" class="form-control" value="{{ $settings['concierge_diamond_includes'] ?? 'Includes Yearly Physical Exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Features List (Type 1 Feature Per Line)</label>
        <textarea name="concierge_diamond_features" class="form-control" style="min-height: 180px;" placeholder="🌟 Unlimited office visits & 2 Doctor Home Visits&#10;⚡ Direct Access to MD/Provider">{{ $settings['concierge_diamond_features'] ?? "🌟 Covers Primary Care: Unlimited office visits & 2 \"Doctor in the house visits\" per year\n⚡ Direct Access to MD/Provider\n📱 20 eTeleMedicine Mobile/Desktop Video Consultations\n✈️ Travel Medicine & Advisory\n🌍 Global Network: Assist with referral to Provider when you travel\n🥗 Weightloss Plan for 21 days included" }}</textarea>
        <small style="color: var(--text-muted); font-size: 0.78rem;">Simply type one bullet point per line. Emojis at the start of a line will be styled automatically.</small>
      </div>
      <div class="form-group">
        <label class="form-label">Spouse Discount Note</label>
        <input type="text" name="concierge_diamond_spouse_discount" class="form-control" value="{{ $settings['concierge_diamond_spouse_discount'] ?? '*Spouses get 25% discount of individual cost in the same plan.' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Button Label</label>
        <input type="text" name="concierge_diamond_btn_text" class="form-control" value="{{ $settings['concierge_diamond_btn_text'] ?? 'Select Diamond Plan' }}">
      </div>
    </div>
  </div>

  <!-- Terms & Notes -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Exclusions & Flexible Payment Terms</h3>
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Exclusions Note</label>
        <textarea name="concierge_exclusions_note" class="form-control" style="min-height: 80px;">{{ $settings['concierge_exclusions_note'] ?? 'Does not cover ER visit, Acute Hospital, Rehab, or Radiology or Lab Test.' }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Payment Terms Note</label>
        <textarea name="concierge_payment_note" class="form-control" style="min-height: 80px;">{{ $settings['concierge_payment_note'] ?? 'Major Credit cards and cash are accepted; Payment Plans are available!' }}</textarea>
      </div>
    </div>
  </div>

  <!-- Concierge Subscription Modal Settings -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Subscription Inquiry Modal Dialog Settings</h3>
    </div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Modal Title</label>
        <input type="text" name="concierge_modal_title" class="form-control" value="{{ $settings['concierge_modal_title'] ?? 'Concierge Plan Membership Inquiry' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Submit Button Label</label>
        <input type="text" name="concierge_modal_btn_text" class="form-control" value="{{ $settings['concierge_modal_btn_text'] ?? '📩 Submit Membership Inquiry' }}">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Modal Subtitle / Description</label>
      <input type="text" name="concierge_modal_subtitle" class="form-control" value="{{ $settings['concierge_modal_subtitle'] ?? "Complete your details below and Dr. Ngomba's medical team will contact you directly to confirm your enrollment." }}">
    </div>
    <div class="form-group">
      <label class="form-label">Success Alert Message (Shown on Submit)</label>
      <textarea name="concierge_modal_success_msg" class="form-control" style="min-height: 70px;">{{ $settings['concierge_modal_success_msg'] ?? "Your Concierge Plan subscription inquiry has been sent successfully! Dr. Ngomba's medical team will contact you shortly." }}</textarea>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">💾 Save Membership Plans & Modal Settings</button>
</form>
@endsection
