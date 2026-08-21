@extends('admin.layouts.admin')

@section('title', 'Chat - AI Chat Assistant')
@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}">Admin</a> <span class="separator">/</span> <span>Chat</span> <span class="separator">/</span> <span>AI Chat Assistant</span>
@endsection
@section('page_title', 'AI Chat Assistant Configuration')

@section('content')
<div class="page-desc-banner">
  <i class="fa-solid fa-robot"></i>
  <p>Manage the greeting message, status header subtitle, input field placeholder, and quick prompt chips for the website's AI Chat Assistant widget.</p>
</div>

<div class="card">
  <div class="card-header">
    <h3>Assistant Header & Greeting Settings</h3>
  </div>

  <form action="{{ route('admin.chat.config.update') }}" method="POST">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Assistant Display Name</label>
        <input type="text" name="assistant_name" class="form-control" value="{{ $config->assistant_name }}">
      </div>

      <div class="form-group">
        <label class="form-label">Status Header Subtitle</label>
        <input type="text" name="status_text" class="form-control" value="{{ $config->status_text }}">
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Initial Welcome Bubble Message</label>
        <textarea name="welcome_message" class="form-control" style="min-height: 100px;">{{ $config->welcome_message }}</textarea>
      </div>

      <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label">Chat Input Field Placeholder</label>
        <input type="text" name="input_placeholder" class="form-control" value="{{ $config->input_placeholder }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">💾 Save Chat Assistant Header Settings</button>
  </form>
</div>
@endsection
