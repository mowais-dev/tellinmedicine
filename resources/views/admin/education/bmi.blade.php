@extends('admin.layouts.admin')

@section('title', 'Patient Education - BMI Calculator')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Patient Education</span> <span class="separator">/</span> <span>BMI Calculator</span>
@endsection
@section('page_title', 'Interactive BMI Calculator Content')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-calculator"></i>
  <p>Manage the headings, descriptions, field labels, and button text for the interactive Body Mass Index (BMI) calculator section on the Patient Education page.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>BMI Calculator Section Headings & Field Labels</h3>
  </div>

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Section Pill Badge</label>
        <input type="text" name="bmi_badge" class="form-control" value="{{ $settings['bmi_badge'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Section Heading</label>
        <input type="text" name="bmi_title" class="form-control" value="{{ $settings['bmi_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Section Subtitle / Note</label>
        <textarea name="bmi_subtitle" class="form-control">{{ $settings['bmi_subtitle'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Calculator Card Title</label>
        <input type="text" name="bmi_card_title" class="form-control" value="{{ $settings['bmi_card_title'] ?? '' }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Calculator Card Description</label>
        <textarea name="bmi_card_desc" class="form-control">{{ $settings['bmi_card_desc'] ?? '' }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Height Field Label</label>
        <input type="text" name="bmi_label_height" class="form-control" value="{{ $settings['bmi_label_height'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Weight Field Label</label>
        <input type="text" name="bmi_label_weight" class="form-control" value="{{ $settings['bmi_label_weight'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Age Field Label</label>
        <input type="text" name="bmi_label_age" class="form-control" value="{{ $settings['bmi_label_age'] ?? '' }}">
      </div>

      <div class="form-group">
        <label class="form-label">Calculate Button Label</label>
        <input type="text" name="bmi_btn_text" class="form-control" value="{{ $settings['bmi_btn_text'] ?? '' }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save BMI Calculator Content</button>
  </form>
</div>
@endsection
