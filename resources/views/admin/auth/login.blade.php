<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - TELLinMedicine Portal</title>
  <link rel="icon" type="image/png" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    :root {
      --brand-blue: #2889C6;
      --brand-blue-hover: #1f74a8;
      --brand-blue-light: #4AA6D8;
      --brand-pink: #CB0E41;
      --brand-pink-hover: #ab0b36;
      
      --bg-page: #E4EEF5;
      --bg-surface: #FFFFFF;
      --bg-surface-secondary: #F4F8FB;
      
      --text-dark: #1F2D3D;
      --text-body: #334155;
      --text-muted: #5E7185;
      
      --border-light: rgba(40, 137, 198, 0.14);
      --border-blue: rgba(40, 137, 198, 0.25);
      
      --grad-blue: linear-gradient(135deg, #2889C6 0%, #4AA6D8 100%);
      --grad-pink: linear-gradient(135deg, #CB0E41 0%, #E11D48 100%);
      --grad-surface: linear-gradient(180deg, #FFFFFF 0%, #F4F8FB 100%);
      
      --card-shadow: 0 16px 40px rgba(31, 45, 61, 0.08), 0 4px 12px rgba(40, 137, 198, 0.06);
      --input-inset: inset 1px 2px 4px rgba(0, 0, 0, 0.03);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: var(--bg-page);
      background-image: 
        radial-gradient(circle at 85% 15%, rgba(40, 137, 198, 0.14), transparent 45%),
        radial-gradient(circle at 15% 85%, rgba(203, 14, 65, 0.08), transparent 50%);
      background-attachment: fixed;
      color: var(--text-body);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      -webkit-font-smoothing: antialiased;
    }

    .login-container {
      width: 100%;
      max-width: 440px;
      margin: auto;
    }

    .login-card {
      background: var(--bg-surface);
      border-radius: 20px;
      border: 1px solid var(--border-light);
      box-shadow: var(--card-shadow);
      padding: 2.5rem 2.25rem;
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--grad-blue);
    }

    .brand-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .brand-header img {
      width: 52px;
      height: 52px;
      object-fit: contain;
      margin-bottom: 0.75rem;
      filter: drop-shadow(0 4px 8px rgba(40, 137, 198, 0.2));
    }

    .brand-header h1 {
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--text-dark);
      letter-spacing: -0.02em;
      margin-bottom: 0.25rem;
    }

    .brand-header p {
      font-size: 0.82rem;
      color: var(--brand-blue);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .alert {
      padding: 0.85rem 1rem;
      border-radius: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: flex-start;
      gap: 0.65rem;
      line-height: 1.4;
    }

    .alert-success {
      background: rgba(40, 137, 198, 0.1);
      border: 1px solid var(--border-blue);
      color: var(--brand-blue);
    }

    .alert-danger {
      background: rgba(203, 14, 65, 0.08);
      border: 1px solid rgba(203, 14, 65, 0.2);
      color: var(--brand-pink);
    }

    .form-group {
      margin-bottom: 1.35rem;
    }

    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 0.45rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--brand-blue);
      font-size: 0.95rem;
      pointer-events: none;
    }

    .form-control {
      width: 100%;
      padding: 0.8rem 1rem 0.8rem 2.6rem;
      background: var(--bg-surface-secondary);
      border: 1px solid var(--border-blue);
      border-radius: 12px;
      font-size: 0.92rem;
      color: var(--text-dark);
      transition: all 0.2s ease;
      box-shadow: var(--input-inset);
    }

    .form-control:focus {
      outline: none;
      background: #FFFFFF;
      border-color: var(--brand-blue);
      box-shadow: 0 0 0 3px rgba(40, 137, 198, 0.18);
    }

    .password-toggle {
      position: absolute;
      right: 0.85rem;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      color: var(--text-muted);
      font-size: 0.95rem;
      cursor: pointer;
      padding: 0.25rem 0.4rem;
      border-radius: 6px;
      transition: color 0.2s ease;
    }

    .password-toggle:hover {
      color: var(--brand-blue);
    }

    .remember-group {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      font-size: 0.85rem;
    }

    .custom-checkbox {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      color: var(--text-body);
      font-weight: 500;
      user-select: none;
    }

    .custom-checkbox input {
      accent-color: var(--brand-blue);
      width: 16px;
      height: 16px;
      cursor: pointer;
    }

    .btn-login {
      width: 100%;
      padding: 0.85rem 1.25rem;
      background: var(--grad-blue);
      color: #FFFFFF;
      border: none;
      border-radius: 12px;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(40, 137, 198, 0.28);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(40, 137, 198, 0.38);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .footer-links {
      margin-top: 1.75rem;
      text-align: center;
      font-size: 0.8rem;
      color: var(--text-muted);
    }

    .footer-links a {
      color: var(--brand-blue);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .footer-links a:hover {
      color: var(--brand-blue-hover);
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 1.75rem 1.35rem;
        border-radius: 16px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-card">
      <div class="brand-header">
        <img src="{{ asset($globalSettings['logo_path'] ?? 'images/logo.png') }}" alt="TELLinMedicine Logo">
        <h1>TELLinMedicine</h1>
        <p>Admin Portal Login</p>
      </div>

      @if (session('success'))
        <div class="alert alert-success">
          <i class="fa-solid fa-circle-check"></i>
          <div>{{ session('success') }}</div>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="fa-solid fa-circle-exclamation"></i>
          <div>
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif

      <form action="{{ route('admin.login.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-label" for="email">Admin Email</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="form-control" 
              placeholder="admin@tellinmedicine.com" 
              value="{{ old('email') }}" 
              required 
              autofocus
            >
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-lock input-icon"></i>
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="form-control" 
              placeholder="••••••••••••" 
              required
            >
            <button type="button" class="password-toggle" id="togglePasswordBtn" title="Toggle password visibility">
              <i class="fa-regular fa-eye" id="toggleIcon"></i>
            </button>
          </div>
        </div>

        <div class="remember-group">
          <label class="custom-checkbox">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Remember me</span>
          </label>
        </div>

        <button type="submit" class="btn-login">
          <i class="fa-solid fa-right-to-bracket"></i> Sign In to Portal
        </button>
      </form>

      <div class="footer-links">
        <p><a href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-globe"></i> Visit TELLinMedicine Website ↗</a></p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const passwordInput = document.getElementById('password');
      const toggleBtn = document.getElementById('togglePasswordBtn');
      const toggleIcon = document.getElementById('toggleIcon');

      if (toggleBtn && passwordInput && toggleIcon) {
        toggleBtn.addEventListener('click', function() {
          const isPassword = passwordInput.type === 'password';
          passwordInput.type = isPassword ? 'text' : 'password';
          toggleIcon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });
      }
    });
  </script>
</body>
</html>
