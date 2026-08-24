@extends('admin.layouts.admin')

@section('title', 'Concierge Medicine - Standard Rates & Tip')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Concierge Medicine</span> <span class="separator">/</span> <span>Standard Rates</span>
@endsection
@section('page_title', 'Out-of-Pocket Standard Rates & Smart Tip')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-tags"></i>
  <p>Manage the Fee-for-Service out-of-pocket pricing boxes and the Smart Health Tip banner on the Concierge page.</p>
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
        <input type="text" name="concierge_rates_badge" class="form-control" value="{{ $settings['concierge_rates_badge'] ?? '💡 Non-Membership Standard Rates' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Main Section Heading</label>
        <input type="text" name="concierge_rates_title" class="form-control" value="{{ $settings['concierge_rates_title'] ?? 'Fee-For-Service Out-of-Pocket Pricing' }}">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Subheading Description</label>
      <input type="text" name="concierge_rates_subtitle" class="form-control" value="{{ $settings['concierge_rates_subtitle'] ?? 'Pay-per-visit pricing for non-concierge patients. Choosing a membership plan below provides significant savings.' }}">
    </div>
  </div>

  <!-- Standard Rates Grid (3 Cards) -->
  <div class="grid-3 mb-4">
    <!-- Card 1 -->
    <div class="card">
      <div class="card-header">
        <h3>Rate Card 1: Routine Office Visit</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_rate1_badge" class="form-control" value="{{ $settings['concierge_rate1_badge'] ?? 'Standard Visit' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="concierge_rate1_icon" class="form-control" value="{{ $settings['concierge_rate1_icon'] ?? '🏥' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Card Title</label>
        <input type="text" name="concierge_rate1_title" class="form-control" value="{{ $settings['concierge_rate1_title'] ?? 'Routine Office Visit' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_rate1_price" class="form-control" value="{{ $settings['concierge_rate1_price'] ?? '$200' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Unit / Period</label>
        <input type="text" name="concierge_rate1_unit" class="form-control" value="{{ $settings['concierge_rate1_unit'] ?? '/ hour' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Description Subtext</label>
        <input type="text" name="concierge_rate1_subtext" class="form-control" value="{{ $settings['concierge_rate1_subtext'] ?? 'In-clinic physician evaluation & consultation' }}">
      </div>
    </div>

    <!-- Card 2 -->
    <div class="card">
      <div class="card-header">
        <h3>Rate Card 2: Physical Exam</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_rate2_badge" class="form-control" value="{{ $settings['concierge_rate2_badge'] ?? 'Annual Exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="concierge_rate2_icon" class="form-control" value="{{ $settings['concierge_rate2_icon'] ?? '🩺' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Card Title</label>
        <input type="text" name="concierge_rate2_title" class="form-control" value="{{ $settings['concierge_rate2_title'] ?? 'Physical Exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_rate2_price" class="form-control" value="{{ $settings['concierge_rate2_price'] ?? '$250' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Unit / Period</label>
        <input type="text" name="concierge_rate2_unit" class="form-control" value="{{ $settings['concierge_rate2_unit'] ?? 'per exam' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Description Subtext</label>
        <input type="text" name="concierge_rate2_subtext" class="form-control" value="{{ $settings['concierge_rate2_subtext'] ?? 'Comprehensive annual preventive physical evaluation' }}">
      </div>
    </div>

    <!-- Card 3 -->
    <div class="card">
      <div class="card-header">
        <h3>Rate Card 3: Doctor Home Visit</h3>
      </div>
      <div class="form-group">
        <label class="form-label">Badge</label>
        <input type="text" name="concierge_rate3_badge" class="form-control" value="{{ $settings['concierge_rate3_badge'] ?? 'At-Home Care' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Icon Emoji</label>
        <input type="text" name="concierge_rate3_icon" class="form-control" value="{{ $settings['concierge_rate3_icon'] ?? '🏠' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Card Title</label>
        <input type="text" name="concierge_rate3_title" class="form-control" value="{{ $settings['concierge_rate3_title'] ?? 'Doctor Home Visits' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Amount</label>
        <input type="text" name="concierge_rate3_price" class="form-control" value="{{ $settings['concierge_rate3_price'] ?? '$300 – $500' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Price Unit / Period</label>
        <input type="text" name="concierge_rate3_unit" class="form-control" value="{{ $settings['concierge_rate3_unit'] ?? 'per visit' }}">
      </div>
      <div class="form-group">
        <label class="form-label">Description Subtext</label>
        <input type="text" name="concierge_rate3_subtext" class="form-control" value="{{ $settings['concierge_rate3_subtext'] ?? 'Physician house calls delivered directly at your doorstep' }}">
      </div>
    </div>
  </div>

  <!-- Smart Tip Banner -->
  <div class="card mb-4">
    <div class="card-header">
      <h3>Smart Health Tip Banner</h3>
    </div>
    <div class="form-group">
      <label class="form-label">Tip Banner Text Content</label>
      <textarea name="concierge_tip_text" class="form-control" style="min-height: 80px;">{{ $settings['concierge_tip_text'] ?? 'All Concierge Membership Plans below include your Yearly Physical Exam ($250 value) plus direct doctor access and multiple visits included for one fixed annual fee!' }}</textarea>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">💾 Save Rates & Tip Settings</button>
</form>
@endsection
