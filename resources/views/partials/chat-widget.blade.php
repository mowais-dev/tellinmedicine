  <!-- Floating Claymorphism Medical AI Chat Widget Trigger Button -->
  <button class="chat-widget-trigger" id="chatWidgetTrigger" aria-label="Open Medical AI Assistant">
    <div class="chat-trigger-icon">💬</div>
    <span class="chat-trigger-label">AI Assistant</span>
    <span class="chat-pulse-dot"></span>
  </button>

  <!-- Claymorphism Medical AI Chat Window -->
  <div class="chat-widget-window" id="chatWidgetWindow">
    <!-- Chat Header -->
    <div class="chat-window-header">
      <div class="chat-header-info">
        <div class="chat-avatar-box">
          🤖
        </div>
        <div>
          <h4 class="chat-assistant-name">{{ $chatConfig->assistant_name ?? 'TELLinCare Assist' }}</h4>
          <span class="chat-status-text">{{ $chatConfig->status_text ?? '🟢 Online | TELLinMedicine Assistant' }}</span>
        </div>
      </div>
      <div class="chat-header-actions">
        <button class="chat-header-btn" id="chatCloseBtn" title="Close Chat">✕</button>
      </div>
    </div>

    <!-- Message Feed -->
    <div class="chat-messages-feed" id="chatMessagesFeed">
      <div class="chat-message bot-message">
        <div class="chat-bubble">{{ trim($chatConfig->welcome_message ?? "Hello! I am TELLinCare Assist, Dr. Ngomba's Medical AI Assistant at TELLinMedicine, LLC. How can I help you today?") }}</div>
        <span class="chat-time">Just now</span>
      </div>
    </div>

    <!-- Chat Input Form -->
    <form class="chat-input-form" id="chatInputForm">
      @csrf
      <textarea id="chatUserInput" class="chat-text-input" rows="1"
        placeholder="{{ $chatConfig->input_placeholder ?? 'Ask about doctor visits, hours, or services...' }}" autocomplete="off"></textarea>
      <button type="submit" class="chat-send-btn" aria-label="Send message">🚀</button>
    </form>
  </div>
