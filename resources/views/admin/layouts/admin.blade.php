<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Portal') - TELLinMedicine</title>
  <link rel="icon" type="image/png" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset($globalSettings['favicon_path'] ?? $globalSettings['logo_path'] ?? 'images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --sidebar-width: 275px;
      
      /* Primary Brand Colors from TELLinMedicine Public Website */
      --brand-blue: #2889C6;
      --brand-blue-hover: #1f74a8;
      --brand-blue-light: #4AA6D8;
      --brand-pink: #CB0E41;
      --brand-pink-hover: #ab0b36;
      
      /* Light Medical Canvas Surfaces */
      --bg-page: #E4EEF5;
      --bg-surface: #FFFFFF;
      --bg-surface-secondary: #F4F8FB;
      
      /* Typography Colors */
      --text-dark: #1F2D3D;
      --text-body: #334155;
      --text-muted: #5E7185;
      
      /* Borders */
      --border-light: rgba(40, 137, 198, 0.14);
      --border-blue: rgba(40, 137, 198, 0.25);
      --border-pink: rgba(203, 14, 65, 0.25);
      
      /* Gradients */
      --grad-blue: linear-gradient(135deg, #2889C6 0%, #4AA6D8 100%);
      --grad-pink: linear-gradient(135deg, #CB0E41 0%, #E11D48 100%);
      --grad-blue-pink: linear-gradient(135deg, #2889C6 0%, #CB0E41 100%);
      --grad-surface: linear-gradient(180deg, #FFFFFF 0%, #F4F8FB 100%);
      --grad-sidebar: linear-gradient(180deg, #FFFFFF 0%, #E4EEF5 100%);
      --grad-active-nav: linear-gradient(135deg, rgba(40, 137, 198, 0.12) 0%, rgba(203, 14, 65, 0.05) 100%);
      
      /* Soft Medical Shadows */
      --card-shadow: 0 10px 30px rgba(31, 45, 61, 0.06), 0 2px 6px rgba(40, 137, 198, 0.04);
      --elevated-shadow: 0 16px 40px rgba(40, 137, 198, 0.12);
      --input-inset: inset 1px 2px 4px rgba(0, 0, 0, 0.03);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html {
      width: 100%;
      max-width: 100%;
      overflow-x: hidden;
    }
    body.admin-panel {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: var(--bg-page);
      background-image: 
        radial-gradient(circle at 90% 10%, rgba(40, 137, 198, 0.12), transparent 45%),
        radial-gradient(circle at 10% 90%, rgba(203, 14, 65, 0.06), transparent 50%);
      background-attachment: fixed;
      color: var(--text-body);
      display: flex;
      min-height: 100vh;
      width: 100%;
      max-width: 100%;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }
    
    /* 3-Section Flex Sidebar Container */
    .admin-panel .sidebar {
      width: var(--sidebar-width);
      background: var(--grad-sidebar);
      color: var(--text-dark);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      height: 100vh;
      z-index: 1000;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border-right: 1px solid var(--border-light);
      box-shadow: 4px 0 24px rgba(40, 137, 198, 0.08);
      overflow: hidden;
    }
    
    /* 1. FIXED HEADER AREA */
    .admin-panel .sidebar-header {
      padding: 1rem 1.25rem;
      background: #FFFFFF;
      border-bottom: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 68px;
      flex-shrink: 0;
    }
    .admin-panel .sidebar-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
    .admin-panel .sidebar-brand img { width: 34px; height: 34px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(40, 137, 198, 0.2)); }
    .admin-panel .sidebar-brand-text h2 { font-size: 1rem; font-weight: 800; color: var(--text-dark); letter-spacing: -0.02em; line-height: 1.1; }
    .admin-panel .sidebar-brand-text span { font-size: 0.62rem; color: var(--brand-blue); text-transform: uppercase; font-weight: 800; letter-spacing: 0.12em; display: block; margin-top: 1px; }

    .admin-panel .sidebar-close-btn {
      display: none;
      background: rgba(40, 137, 198, 0.08);
      border: 1px solid var(--border-light);
      color: var(--text-dark);
      width: 32px;
      height: 32px;
      border-radius: 8px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }
    .admin-panel .sidebar-close-btn:hover {
      background: rgba(203, 14, 65, 0.1);
      color: var(--brand-pink);
    }
    
    /* 2. SCROLLABLE NAVIGATION WRAPPER */
    .admin-panel .sidebar-nav-wrapper {
      flex: 1;
      min-height: 0; /* Critical for flexbox child overflow scrollability */
      overflow-y: auto;
      overflow-x: hidden;
      padding: 0.75rem 0.65rem;
      scrollbar-width: thin;
      scrollbar-color: rgba(40, 137, 198, 0.22) transparent;
    }
    .admin-panel .sidebar-nav-wrapper::-webkit-scrollbar {
      width: 6px;
    }
    .admin-panel .sidebar-nav-wrapper::-webkit-scrollbar-track {
      background: transparent;
    }
    .admin-panel .sidebar-nav-wrapper::-webkit-scrollbar-thumb {
      background: rgba(40, 137, 198, 0.22);
      border-radius: 10px;
    }
    .admin-panel .sidebar-nav-wrapper::-webkit-scrollbar-thumb:hover {
      background: rgba(40, 137, 198, 0.45);
    }
    
    .admin-panel .sidebar-nav {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }
    
    .admin-panel .nav-group-label {
      font-size: 0.65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      color: var(--brand-blue);
      padding: 0.85rem 0.75rem 0.25rem;
    }
    
    .admin-panel .nav-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.7rem 0.85rem;
      color: var(--text-body);
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.2s ease;
      min-height: 42px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .admin-panel .nav-item:hover {
      background: #FFFFFF;
      color: var(--brand-blue);
      box-shadow: 0 4px 12px rgba(40, 137, 198, 0.08);
    }
    .admin-panel .nav-item.active {
      background: var(--grad-active-nav);
      color: var(--brand-blue);
      font-weight: 800;
      border-left: 3px solid var(--brand-blue);
    }
    .admin-panel .sidebar-icon,
    .admin-panel .nav-item .icon,
    .admin-panel .nav-accordion-header .icon {
      font-size: 1rem;
      width: 20px;
      min-width: 20px;
      text-align: center;
      color: var(--brand-blue);
      transition: transform 0.2s ease;
      flex-shrink: 0;
    }
    .admin-panel .nav-item:hover .icon,
    .admin-panel .nav-accordion-header:hover .icon { transform: scale(1.15); }
    
    /* Expandable Accordion Menu with Modern Grid Transition */
    .admin-panel .nav-accordion {
      display: flex;
      flex-direction: column;
      border-radius: 10px;
    }
    .admin-panel .nav-accordion-header {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.7rem 0.85rem;
      background: transparent;
      border: none;
      color: var(--text-body);
      font-size: 0.88rem;
      font-weight: 600;
      font-family: inherit;
      cursor: pointer;
      border-radius: 10px;
      transition: all 0.2s ease;
      text-align: left;
      min-height: 42px;
    }
    .admin-panel .nav-accordion-header:hover {
      background: #FFFFFF;
      color: var(--brand-blue);
      box-shadow: 0 4px 12px rgba(40, 137, 198, 0.08);
    }
    .admin-panel .nav-accordion-header.active {
      color: var(--brand-blue);
      font-weight: 800;
      background: rgba(40, 137, 198, 0.08);
    }
    .admin-panel .nav-accordion-title {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .admin-panel .nav-accordion .chevron {
      font-size: 0.75rem;
      color: var(--text-muted);
      transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      margin-left: auto;
      flex-shrink: 0;
    }
    .admin-panel .nav-accordion.open .chevron {
      transform: rotate(180deg);
      color: var(--brand-blue);
    }
    .admin-panel .nav-accordion-body {
      display: grid;
      grid-template-rows: 0fr;
      overflow: hidden;
      visibility: hidden;
      opacity: 0;
      transition: grid-template-rows 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease, visibility 0.25s ease;
    }
    .admin-panel .nav-accordion.open .nav-accordion-body {
      grid-template-rows: 1fr;
      visibility: visible;
      opacity: 1;
    }
    .admin-panel .nav-accordion-body-inner {
      min-height: 0;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 0.15rem;
      padding-left: 0.85rem;
      padding-top: 0.25rem;
      padding-bottom: 0.25rem;
    }
    .admin-panel .nav-subitem {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.55rem 0.75rem;
      color: var(--text-body);
      text-decoration: none;
      font-size: 0.83rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.2s ease;
      border-left: 2px solid transparent;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 36px;
    }
    .admin-panel .nav-subitem:hover {
      background: #FFFFFF;
      color: var(--brand-blue);
      transform: translateX(3px);
    }
    .admin-panel .nav-subitem.active {
      background: var(--grad-active-nav);
      color: var(--brand-blue);
      font-weight: 700;
      border-left: 3px solid var(--brand-blue);
    }
    .admin-panel .nav-subitem .subicon {
      font-size: 0.85rem;
      width: 18px;
      min-width: 18px;
      text-align: center;
      color: var(--brand-blue);
      opacity: 0.85;
      flex-shrink: 0;
    }

    /* 3. FIXED FOOTER AREA */
    .admin-panel .sidebar-footer {
      padding: 0.9rem 1.25rem;
      border-top: 1px solid var(--border-light);
      background: #FFFFFF;
      font-size: 0.75rem;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
    }
    
    /* Layout & Main Section */
    .admin-panel .main-wrapper {
      margin-left: var(--sidebar-width);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
      max-width: 100%;
      overflow-x: hidden;
      transition: margin-left 0.3s ease;
    }
    
    /* Light Medical Topbar */
    .admin-panel .topbar {
      background: #FFFFFF;
      border-bottom: 1px solid var(--border-light);
      padding: 0.85rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 20px rgba(31, 45, 61, 0.03);
      position: sticky;
      top: 0;
      z-index: 90;
    }
    .admin-panel .topbar-left { display: flex; align-items: center; gap: 1rem; }
    .admin-panel .admin-breadcrumbs {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.76rem;
      font-weight: 700;
      color: var(--text-muted);
      margin-bottom: 0.15rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }
    .admin-panel .admin-breadcrumbs a {
      color: var(--brand-blue);
      text-decoration: none;
    }
    .admin-panel .admin-breadcrumbs a:hover {
      text-decoration: underline;
    }
    .admin-panel .admin-breadcrumbs .separator {
      font-size: 0.65rem;
      color: var(--text-muted);
      opacity: 0.6;
    }
    .admin-panel .topbar h1 { font-size: 1.3rem; font-weight: 800; color: var(--text-dark); letter-spacing: -0.02em; }
    .admin-panel .mobile-toggle {
      display: none;
      background: var(--bg-surface-secondary);
      border: 1px solid var(--border-blue);
      color: var(--brand-blue);
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.1rem;
      align-items: center;
      justify-content: center;
    }
    
    /* Public View Website & Admin Topbar Actions */
    .admin-panel .topbar-actions {
      display: flex;
      align-items: center;
      gap: 0.85rem;
    }
    .admin-panel .btn-view-site {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.55rem 1.1rem;
      background: var(--grad-blue);
      color: #FFFFFF;
      border-radius: 20px;
      font-size: 0.82rem;
      font-weight: 700;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(40, 137, 198, 0.25);
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .admin-panel .btn-view-site:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(40, 137, 198, 0.35);
      color: #FFFFFF;
    }
    .admin-panel .topbar-user-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.45rem 0.85rem;
      background: var(--bg-surface-secondary);
      border: 1px solid var(--border-blue);
      border-radius: 20px;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text-dark);
    }
    .admin-panel .topbar-user-badge i {
      color: var(--brand-blue);
    }
    .admin-panel .btn-logout {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.55rem 1rem;
      background: var(--grad-pink);
      color: #FFFFFF;
      border: none;
      border-radius: 20px;
      font-size: 0.82rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(203, 14, 65, 0.22);
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .admin-panel .btn-logout:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(203, 14, 65, 0.35);
    }

    /* Mobile Backdrop */
    .admin-panel .sidebar-backdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.45);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 999;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .admin-panel .sidebar-backdrop.active {
      display: block;
      opacity: 1;
    }
    
    /* Page Canvas Area */
    .admin-panel .content-area {
      padding: 2rem;
      flex: 1;
      width: 100%;
      max-width: 100%;
      box-sizing: border-box;
    }

    .admin-panel .page-desc-banner {
      background: rgba(40, 137, 198, 0.07);
      border: 1px solid var(--border-blue);
      border-radius: 14px;
      padding: 1.1rem 1.4rem;
      margin-bottom: 1.75rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .admin-panel .page-desc-banner i {
      font-size: 1.5rem;
      color: var(--brand-blue);
      flex-shrink: 0;
    }
    .admin-panel .page-desc-banner p {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--text-dark);
      line-height: 1.5;
    }
    
    /* Surface Cards & Form Containers */
    .admin-panel .card {
      background: var(--bg-surface);
      border-radius: 16px;
      border: 1px solid var(--border-light);
      box-shadow: var(--card-shadow);
      padding: 1.75rem;
      margin-bottom: 2rem;
      width: 100%;
      max-width: 100%;
      box-sizing: border-box;
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .admin-panel .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-bottom: 1rem;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid var(--border-light);
      max-width: 100%;
      box-sizing: border-box;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .admin-panel .card-header h3 {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--text-dark);
      letter-spacing: -0.01em;
      word-break: break-word;
      overflow-wrap: break-word;
      max-width: 100%;
    }
    .admin-panel code {
      word-break: break-all;
      overflow-wrap: break-word;
    }
    
    /* Grid Utilities */
    .admin-panel .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
    .admin-panel .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
    .admin-panel .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
    
    /* Form Inputs & Controls */
    .admin-panel .form-group { margin-bottom: 1.25rem; }
    .admin-panel .form-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 0.4rem;
      text-transform: uppercase;
      letter-spacing: 0.03em;
    }
    .admin-panel .form-control {
      width: 100%;
      max-width: 100%;
      padding: 0.75rem 1rem;
      background: var(--bg-surface-secondary);
      border: 1px solid var(--border-blue);
      border-radius: 10px;
      font-size: 0.92rem;
      color: var(--text-dark);
      transition: all 0.2s ease;
      box-shadow: var(--input-inset);
    }
    .admin-panel select.form-control {
      max-width: 100%;
      width: 100%;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
    }
    .admin-panel select option {
      font-size: 0.9rem;
      padding: 0.5rem;
    }
    .admin-panel .form-control:focus {
      outline: none;
      background: #FFFFFF;
      border-color: var(--brand-blue);
      box-shadow: 0 0 0 3px rgba(40, 137, 198, 0.15);
    }
    .admin-panel textarea.form-control { min-height: 100px; resize: vertical; }
    
    /* Image Uploader & Media Selector */
    .admin-panel .image-picker-box {
      border: 2px dashed var(--border-blue);
      border-radius: 12px;
      padding: 1.25rem;
      text-align: center;
      background: var(--bg-surface-secondary);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .admin-panel .image-picker-box:hover {
      border-color: var(--brand-blue);
      background: #FFFFFF;
    }
    .admin-panel .image-preview-img {
      max-width: 100%;
      max-height: 140px;
      object-fit: contain;
      border-radius: 8px;
      margin-bottom: 0.5rem;
    }
    
    /* Primary Action Buttons */
    .admin-panel .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.75rem 1.4rem;
      border-radius: 10px;
      font-size: 0.88rem;
      font-weight: 700;
      cursor: pointer;
      border: none;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    .admin-panel .btn-primary {
      background: var(--grad-blue);
      color: #FFFFFF;
      box-shadow: 0 4px 14px rgba(40, 137, 198, 0.25);
    }
    .admin-panel .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(40, 137, 198, 0.35);
    }
    .admin-panel .btn-secondary {
      background: #E4EEF5;
      color: var(--text-dark);
      border: 1px solid var(--border-blue);
    }
    .admin-panel .btn-secondary:hover {
      background: #FFFFFF;
      color: var(--brand-blue);
    }
    .admin-panel .btn-danger {
      background: var(--grad-pink);
      color: #FFFFFF;
      box-shadow: 0 4px 14px rgba(203, 14, 65, 0.25);
    }
    .admin-panel .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(203, 14, 65, 0.35);
    }
    .admin-panel .btn-sm {
      padding: 0.45rem 0.85rem;
      font-size: 0.8rem;
      border-radius: 8px;
    }
    
    /* Alerts */
    .admin-panel .alert-success {
      background: rgba(40, 137, 198, 0.1);
      border: 1px solid var(--border-blue);
      color: var(--brand-blue);
      padding: 1rem 1.25rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-weight: 700;
    }
    
    /* Clean Medical Tables & Responsive Layouts */
    .admin-panel .table-responsive {
      width: 100%;
      overflow-x: auto;
      border-radius: 14px;
      border: 1px solid var(--border-light);
      border-top: 3px solid var(--brand-blue);
      background: #FFFFFF;
      box-shadow: 0 8px 24px rgba(31, 45, 61, 0.05);
      -webkit-overflow-scrolling: touch;
    }
    .admin-panel table {
      width: 100%;
      min-width: 1250px;
      border-collapse: separate;
      border-spacing: 0;
      text-align: left;
      table-layout: auto !important;
    }
    .admin-panel th {
      padding: 1rem 1.15rem;
      background: var(--bg-surface-secondary);
      font-size: 0.75rem;
      font-weight: 800;
      color: var(--text-dark);
      text-transform: uppercase;
      border-bottom: 1px solid var(--border-light);
      letter-spacing: 0.08em;
      white-space: nowrap;
      vertical-align: middle;
    }
    .admin-panel td {
      padding: 1rem 1.15rem;
      border-bottom: 1px solid #F1F5F9;
      font-size: 0.88rem;
      vertical-align: middle;
      color: var(--text-dark);
    }
    .admin-panel tr:last-child td { border-bottom: none; }
    .admin-panel tr:hover td { background: rgba(40, 137, 198, 0.04); }

    /* In-Table Form Inputs */
    .admin-panel table .form-control {
      width: 100% !important;
      box-sizing: border-box !important;
      padding: 0.65rem 0.85rem !important;
      font-size: 0.88rem !important;
      min-height: 42px !important;
      line-height: 1.4 !important;
    }

    /* In-Table Number / Order Inputs */
    .admin-panel table input[type="number"].form-control,
    .admin-panel table input[name="order"].form-control {
      padding: 0.5rem 0.35rem !important;
      text-align: center !important;
      font-weight: 700 !important;
      font-size: 0.92rem !important;
      min-width: 68px !important;
      max-width: 85px !important;
      margin: 0 auto !important;
    }

    /* In-Table Icon Emoji Inputs */
    .admin-panel table input[name="icon"].form-control {
      padding: 0.5rem 0.35rem !important;
      text-align: center !important;
      font-size: 1.1rem !important;
      min-width: 68px !important;
      max-width: 85px !important;
      margin: 0 auto !important;
    }

    /* In-Table Status Select Dropdowns */
    .admin-panel table select[name="is_active"].form-control {
      padding: 0.5rem 0.4rem !important;
      font-size: 0.85rem !important;
      font-weight: 700 !important;
      min-width: 110px !important;
      width: 100% !important;
      text-align: center !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 992px) {
      .admin-panel .sidebar {
        transform: translateX(-100%);
      }
      .admin-panel .sidebar.open {
        transform: translateX(0);
      }
      .admin-panel .sidebar-close-btn {
        display: flex;
      }
      .admin-panel .main-wrapper {
        margin-left: 0;
        width: 100%;
      }
      .admin-panel .mobile-toggle {
        display: flex;
      }
      .admin-panel .topbar {
        padding: 0.75rem 1rem;
        gap: 0.75rem;
        flex-wrap: wrap;
      }
      .admin-panel .topbar-left {
        width: 100%;
        justify-content: flex-start;
      }
      .admin-panel .topbar-actions {
        width: 100%;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding-top: 0.25rem;
        border-top: 1px dashed var(--border-light);
      }
      .admin-panel .topbar h1 {
        font-size: 1.15rem;
      }
      .admin-panel .content-area {
        padding: 1.25rem;
      }
      .admin-panel .grid-2,
      .admin-panel .grid-3,
      .admin-panel .grid-4 {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
      }
    }

    @media (max-width: 576px) {
      .admin-panel .topbar {
        padding: 0.75rem 0.85rem;
        gap: 0.6rem;
      }
      .admin-panel .topbar-left {
        width: 100%;
        justify-content: flex-start;
      }
      .admin-panel .topbar-actions {
        width: 100%;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 0.35rem;
      }
      .admin-panel .btn-view-site,
      .admin-panel .topbar-user-badge,
      .admin-panel .btn-logout {
        padding: 0.4rem 0.65rem;
        font-size: 0.76rem;
        border-radius: 12px;
        white-space: nowrap;
      }
      .admin-panel .card {
        padding: 1rem !important;
        border-radius: 12px !important;
        margin-bottom: 1.25rem !important;
      }
      .admin-panel .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }
      .admin-panel .card-header h3 {
        font-size: 1.05rem;
      }
      .admin-panel .content-area {
        padding: 0.85rem;
      }
    }
  </style>
  @stack('styles')
</head>
<body class="admin-panel">

  <!-- Mobile Overlay Backdrop -->
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <!-- Reorganized Client-Friendly Sidebar -->
  <aside class="sidebar" id="adminSidebar">
    <!-- 1. FIXED HEADER AREA -->
    <div class="sidebar-header">
      <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <img src="{{ asset($globalSettings['logo_path'] ?? 'images/logo.png') }}" alt="Logo">
        <div class="sidebar-brand-text">
          <h2>TELLinMedicine</h2>
          <span>Admin Portal</span>
        </div>
      </a>
      <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close Sidebar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- 2. SCROLLABLE NAVIGATION WRAPPER -->
    <div class="sidebar-nav-wrapper" id="sidebarNavWrapper">
      <nav class="sidebar-nav">
        <!-- MAIN SECTION -->
        <div class="nav-group-label">MAIN</div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-gauge-high icon"></i> Dashboard
        </a>

        <!-- Home Accordion -->
        <div class="nav-accordion {{ Request::routeIs('admin.home.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.home.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-house icon"></i> Home Page</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.home.hero') }}" class="nav-subitem {{ Request::routeIs('admin.home.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles subicon"></i> Hero Section
              </a>
              <a href="{{ route('admin.home.pillars') }}" class="nav-subitem {{ Request::routeIs('admin.home.pillars') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group subicon"></i> Pillars of Care
              </a>
              <a href="{{ route('admin.home.schedule') }}" class="nav-subitem {{ Request::routeIs('admin.home.schedule') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days subicon"></i> Practice Schedule
              </a>
              <a href="{{ route('admin.home.services') }}" class="nav-subitem {{ Request::routeIs('admin.home.services') ? 'active' : '' }}">
                <i class="fa-solid fa-stethoscope subicon"></i> Services
              </a>
              <a href="{{ route('admin.home.specialists') }}" class="nav-subitem {{ Request::routeIs('admin.home.specialists') ? 'active' : '' }}">
                <i class="fa-solid fa-user-doctor subicon"></i> Our Specialists
              </a>
              <a href="{{ route('admin.home.contact') }}" class="nav-subitem {{ Request::routeIs('admin.home.contact') ? 'active' : '' }}">
                <i class="fa-solid fa-location-dot subicon"></i> Contact & Location
              </a>
            </div>
          </div>
        </div>

        <!-- Meet Dr. Ngomba Accordion -->
        <div class="nav-accordion {{ Request::routeIs('admin.doctor.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.doctor.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-user-doctor icon"></i> Meet Dr. Ngomba</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.doctor.profile') }}" class="nav-subitem {{ Request::routeIs('admin.doctor.profile') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card subicon"></i> Doctor Profile
              </a>
              <a href="{{ route('admin.doctor.timeline') }}" class="nav-subitem {{ Request::routeIs('admin.doctor.timeline') ? 'active' : '' }}">
                <i class="fa-solid fa-timeline subicon"></i> Career Timeline
              </a>
            </div>
          </div>
        </div>

        <!-- Our Philosophy Accordion -->
        <div class="nav-accordion {{ Request::routeIs('admin.philosophy.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.philosophy.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-lightbulb icon"></i> Our Philosophy</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.philosophy.hero') }}" class="nav-subitem {{ Request::routeIs('admin.philosophy.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles subicon"></i> Hero Section
              </a>
              <a href="{{ route('admin.philosophy.article') }}" class="nav-subitem {{ Request::routeIs('admin.philosophy.article') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines subicon"></i> Philosophy Article
              </a>
              <a href="{{ route('admin.philosophy.pillars') }}" class="nav-subitem {{ Request::routeIs('admin.philosophy.pillars') ? 'active' : '' }}">
                <i class="fa-solid fa-heart-pulse subicon"></i> Philosophy Pillars
              </a>
            </div>
          </div>
        </div>

        <!-- Patient Education Accordion -->
        <div class="nav-accordion {{ Request::routeIs('admin.education.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.education.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-book-medical icon"></i> Patient Education</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.education.hero') }}" class="nav-subitem {{ Request::routeIs('admin.education.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles subicon"></i> Hero Section
              </a>
              <a href="{{ route('admin.education.bmi') }}" class="nav-subitem {{ Request::routeIs('admin.education.bmi') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator subicon"></i> BMI Calculator
              </a>
              <a href="{{ route('admin.education.guides') }}" class="nav-subitem {{ Request::routeIs('admin.education.guides') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open subicon"></i> Education Guides
              </a>
              <a href="{{ route('admin.education.checklists') }}" class="nav-subitem {{ Request::routeIs('admin.education.checklists') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check subicon"></i> Preventive Checklists
              </a>
            </div>
          </div>
        </div>

        <!-- Concierge Medicine Accordion -->
        <div class="nav-accordion {{ Request::routeIs('admin.concierge.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.concierge.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-gem icon"></i> Concierge Medicine</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.concierge.hero') }}" class="nav-subitem {{ Request::routeIs('admin.concierge.hero') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles subicon"></i> Hero Section
              </a>
              <a href="{{ route('admin.concierge.rates') }}" class="nav-subitem {{ Request::routeIs('admin.concierge.rates') ? 'active' : '' }}">
                <i class="fa-solid fa-tags subicon"></i> Standard Rates & Tip
              </a>
              <a href="{{ route('admin.concierge.plans') }}" class="nav-subitem {{ Request::routeIs('admin.concierge.plans') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group subicon"></i> Membership Tiers
              </a>
              <a href="{{ route('admin.concierge.faq') }}" class="nav-subitem {{ Request::routeIs('admin.concierge.faq') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question subicon"></i> FAQs & Facility Info
              </a>
              <a href="{{ route('admin.concierge.cta') }}" class="nav-subitem {{ Request::routeIs('admin.concierge.cta') ? 'active' : '' }}">
                <i class="fa-solid fa-bullseye subicon"></i> Bottom Callout Banner
              </a>
            </div>
          </div>
        </div>

        <!-- WEBSITE SECTION -->
        <div class="nav-group-label">WEBSITE</div>

        <div class="nav-accordion {{ Request::routeIs('admin.website.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.website.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-globe icon"></i> Website</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.website.marquee') }}" class="nav-subitem {{ Request::routeIs('admin.website.marquee') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn subicon"></i> Marquee / Top Bar
              </a>
              <a href="{{ route('admin.website.navigation') }}" class="nav-subitem {{ Request::routeIs('admin.website.navigation') ? 'active' : '' }}">
                <i class="fa-solid fa-bars subicon"></i> Header & Navigation
              </a>
              <a href="{{ route('admin.website.footer') }}" class="nav-subitem {{ Request::routeIs('admin.website.footer') ? 'active' : '' }}">
                <i class="fa-solid fa-window-maximize subicon"></i> Footer
              </a>
              <a href="{{ route('admin.website.media') }}" class="nav-subitem {{ Request::routeIs('admin.website.media') ? 'active' : '' }}">
                <i class="fa-solid fa-images subicon"></i> Media Library
              </a>
            </div>
          </div>
        </div>

        <!-- NOTIFICATIONS SECTION -->
        <div class="nav-group-label">NOTIFICATIONS & EMAILS</div>

        <div class="nav-accordion {{ Request::routeIs('admin.emails*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.emails*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-envelope-open-text icon"></i> Notification Emails</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.emails') }}" class="nav-subitem {{ Request::routeIs('admin.emails') ? 'active' : '' }}">
                <i class="fa-solid fa-at subicon"></i> Email Recipients
              </a>
            </div>
          </div>
        </div>

        <!-- MODALS & POPUPS SECTION -->
        <div class="nav-group-label">MODALS & POPUPS</div>

        <div class="nav-accordion {{ Request::routeIs('admin.modals.*') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.modals.*') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-window-restore icon"></i> Modals & Popups</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.modals.booking') }}" class="nav-subitem {{ Request::routeIs('admin.modals.booking') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check subicon"></i> Appointment Booking Modal
              </a>
            </div>
          </div>
        </div>

        <!-- CHAT SECTION -->
        <div class="nav-group-label">CHAT</div>

        <div class="nav-accordion {{ Request::routeIs('admin.chat') ? 'open' : '' }}">
          <button class="nav-accordion-header {{ Request::routeIs('admin.chat') ? 'active' : '' }}" type="button">
            <span class="nav-accordion-title"><i class="fa-solid fa-comments icon"></i> Chat</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
          </button>
          <div class="nav-accordion-body">
            <div class="nav-accordion-body-inner">
              <a href="{{ route('admin.chat') }}" class="nav-subitem {{ Request::routeIs('admin.chat') ? 'active' : '' }}">
                <i class="fa-solid fa-robot subicon"></i> AI Chat Assistant
              </a>
            </div>
          </div>
        </div>
      </nav>
    </div>

    <!-- 3. FIXED FOOTER AREA -->
    <div class="sidebar-footer">
      <div><strong>TELLin</strong> v2.0</div>
      <div>&copy; 2026</div>
    </div>
  </aside>

  <!-- Main Content Area -->
  <div class="main-wrapper">
    <div class="topbar">
      <div class="topbar-left">
        <button class="mobile-toggle" id="sidebarToggle" aria-label="Toggle Sidebar"><i class="fa-solid fa-bars"></i></button>
        <div>
          <div class="admin-breadcrumbs">
            @yield('breadcrumbs')
          </div>
          <h1>@yield('page_title', 'Admin Dashboard')</h1>
        </div>
      </div>
      <div class="topbar-actions">
        <a href="{{ url('/') }}" target="_blank" class="btn-view-site">
          <i class="fa-solid fa-globe"></i> View Public Website ↗
        </a>
        @auth
          <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout" title="Log out of Admin Portal">
              <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
          </form>
        @endauth
      </div>
    </div>

    <div class="content-area">
      @if(session('success'))
        <div class="alert-success">
          <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert-danger" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem;">
          <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert-danger" style="background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 0.85rem 1.25rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.9rem;">
          <i class="fa-solid fa-triangle-exclamation"></i> <strong>Please correct the following errors:</strong>
          <ul style="margin-top: 0.4rem; padding-left: 1.2rem; margin-bottom: 0;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Accordion Menu Collapsible Logic
      const accordionHeaders = document.querySelectorAll('.nav-accordion-header');
      accordionHeaders.forEach(function(header) {
        header.addEventListener('click', function(e) {
          e.preventDefault();
          const parent = this.parentElement;
          const isOpen = parent.classList.contains('open');

          if (!isOpen) {
            parent.classList.add('open');
          } else {
            parent.classList.remove('open');
          }
        });
      });

      // Auto-scroll active item into view within sidebar navigation wrapper
      const activeNav = document.querySelector('.sidebar-nav .active');
      if (activeNav) {
        const navWrapper = document.getElementById('sidebarNavWrapper');
        if (navWrapper) {
          setTimeout(function() {
            const wrapperRect = navWrapper.getBoundingClientRect();
            const activeRect = activeNav.getBoundingClientRect();
            if (activeRect.bottom > wrapperRect.bottom || activeRect.top < wrapperRect.top) {
              activeNav.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
          }, 100);
        }
      }

      // Mobile Drawer Toggles
      const sidebar = document.getElementById('adminSidebar');
      const toggleBtn = document.getElementById('sidebarToggle');
      const closeBtn = document.getElementById('sidebarCloseBtn');
      const backdrop = document.getElementById('sidebarBackdrop');

      function openSidebar() {
        sidebar?.classList.add('open');
        backdrop?.classList.add('active');
      }

      function closeSidebar() {
        sidebar?.classList.remove('open');
        backdrop?.classList.remove('active');
      }

      toggleBtn?.addEventListener('click', openSidebar);
      closeBtn?.addEventListener('click', closeSidebar);
      backdrop?.addEventListener('click', closeSidebar);

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
