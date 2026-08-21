function showThemeAlert(title, text, icon = 'info', html = null) {
  if (typeof Swal !== 'undefined') {
    const opts = {
      title: title,
      icon: icon,
      confirmButtonColor: '#1A84C5',
      confirmButtonText: 'Got It',
      heightAuto: false,
      scrollbarPadding: false,
      returnFocus: false,
      focusConfirm: false,
      focusCancel: false,
      customClass: {
        popup: 'clay-swal-popup',
        title: 'clay-swal-title',
        confirmButton: 'clay-swal-confirm-btn'
      }
    };
    if (html) {
      opts.html = html;
    } else {
      opts.text = text;
    }
    Swal.fire(opts);
  } else {
    alert(text || title);
  }
}

function showThemeToast(title, icon = 'warning') {
  if (typeof Swal !== 'undefined') {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500,
      timerProgressBar: true,
      heightAuto: false,
      scrollbarPadding: false,
      returnFocus: false,
      focusConfirm: false,
      focusCancel: false,
      customClass: {
        popup: 'clay-swal-toast'
      },
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
    Toast.fire({
      icon: icon,
      title: title
    });
  } else {
    alert(title);
  }
}

function parseTimeRangeToSlots(hoursStr, intervalMinutes = 30) {
  if (!hoursStr || typeof hoursStr !== 'string') return [];

  try {
    const regex = /(\d{1,2})(?::(\d{2}))?\s*(AM|PM)/gi;
    const matches = [...hoursStr.matchAll(regex)];

    if (!matches || matches.length < 2) return [];

    function parseToMinutes(match) {
      let hour = parseInt(match[1], 10);
      const minute = match[2] ? parseInt(match[2], 10) : 0;
      const period = match[3].toUpperCase();

      if (period === 'PM' && hour < 12) hour += 12;
      if (period === 'AM' && hour === 12) hour = 0;

      return hour * 60 + minute;
    }

    const startMins = parseToMinutes(matches[0]);
    const endMins = parseToMinutes(matches[1]);

    if (endMins <= startMins) return [];

    const slots = [];
    for (let current = startMins; current <= endMins; current += intervalMinutes) {
      let h = Math.floor(current / 60);
      const m = current % 60;
      const period = h >= 12 ? 'PM' : 'AM';

      let displayHour = h % 12;
      if (displayHour === 0) displayHour = 12;

      const displayMin = String(m).padStart(2, '0');
      slots.push(`${displayHour}:${displayMin} ${period}`);
    }

    return slots;
  } catch (err) {
    console.warn('Error parsing time range:', err);
    return [];
  }
}

function getCareModelLabel(modelKey) {
  if (modelKey === 'In-Clinic') return window.careModelNames?.inClinic || modelKey;
  if (modelKey === 'Home Visit') return window.careModelNames?.homeVisit || modelKey;
  if (modelKey === 'Telehealth' || modelKey === 'E-Appointments') return window.careModelNames?.telehealth || modelKey;
  return modelKey || '';
}

function handleHomeVisitEligibility(form) {
  if (!form) return;
  const careInput = form.querySelector('input[name="care_model"]');
  const selectedModel = (careInput ? careInput.value : '').toLowerCase();

  const isHomeVisit = selectedModel.includes('home');
  const eligibilityWrapper = form.querySelector('.home-visit-eligibility-wrapper');
  const standardFields = form.querySelector('.standard-booking-fields');
  const ageInput = form.querySelector('.home-visit-age-input');
  const disabledCheck = form.querySelector('.home-visit-disabled-check');
  const ineligibleMsg = form.querySelector('.home-visit-ineligible-msg');

  if (!standardFields) return;

  // Standard fields (Name, Phone, Email, Age, Date, Time, Reason) are ALWAYS visible for ALL care models
  standardFields.style.display = 'block';

  if (!isHomeVisit) {
    if (eligibilityWrapper) eligibilityWrapper.style.display = 'none';
    if (ineligibleMsg) ineligibleMsg.style.display = 'none';
  } else {
    // Show Home Visit Criteria & Disability Checkbox
    if (eligibilityWrapper) eligibilityWrapper.style.display = 'block';

    const ageVal = parseInt(ageInput ? ageInput.value : 0, 10) || 0;
    const isDisabled = disabledCheck ? disabledCheck.checked : false;
    const hasInput = (ageInput && ageInput.value.trim() !== '') || isDisabled;

    if (hasInput && ageVal < 65 && !isDisabled) {
      if (ineligibleMsg) ineligibleMsg.style.display = 'block';
    } else {
      if (ineligibleMsg) ineligibleMsg.style.display = 'none';
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  initMobileNavigation();
  initBookingModal();
  initBMICalculator();
  initServiceTabs();
  init3DParallax();
  initScrollParallax();
  initScrollReveal();
  initInteractiveCalendar();
  initOpenAIChatbot();
  initPracticeStatus();
});

/* ==========================================================================
   Mobile Navigation Toggle
   ========================================================================== */

function initMobileNavigation() {
  const toggleBtn = document.querySelector('.mobile-toggle');
  const navMenu = document.querySelector('.nav-menu');
  const navLinks = document.querySelectorAll('.nav-link');

  if (!toggleBtn || !navMenu) return;

  toggleBtn.addEventListener('click', () => {
    navMenu.classList.toggle('is-active');
  });

  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('is-active');
    });
  });
}

/* ==========================================================================
   Medical AI Assistant Widget (Live OpenAI + Smart Demo Fallback)
   ========================================================================== */

function initOpenAIChatbot() {
  const triggerBtn = document.getElementById('chatWidgetTrigger');
  const chatWindow = document.getElementById('chatWidgetWindow');
  const closeBtn = document.getElementById('chatCloseBtn');

  const messagesFeed = document.getElementById('chatMessagesFeed');
  const chatForm = document.getElementById('chatInputForm');
  const userInput = document.getElementById('chatUserInput');

  if (!chatWindow) return;

  // Toggle Window
  triggerBtn.addEventListener('click', () => {
    chatWindow.classList.toggle('is-open');
    if (chatWindow.classList.contains('is-open')) {
      userInput.focus();
    }
  });

  closeBtn.addEventListener('click', () => chatWindow.classList.remove('is-open'));

  // Multiline Textarea Keydown (Shift+Enter for newline, Enter to send)
  if (userInput) {
    userInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        chatForm.requestSubmit();
      }
    });

    userInput.addEventListener('input', () => {
      userInput.style.height = 'auto';
      const newHeight = Math.min(userInput.scrollHeight, 120);
      userInput.style.height = newHeight + 'px';
      if (userInput.scrollHeight > 120) {
        userInput.style.overflowY = 'auto';
      } else {
        userInput.style.overflowY = 'hidden';
      }
    });
  }

  let conversationHistory = [];

  function formatChatMessage(text) {
    if (!text) return '';
    let escaped = escapeHtml(text).trim();
    return escaped.replace(/\n/g, '<br>');
  }

  function appendUserMessage(text) {
    const msgDiv = document.createElement('div');
    msgDiv.className = 'chat-message user-message';
    msgDiv.innerHTML = `<div class="chat-bubble">${formatChatMessage(text)}</div><span class="chat-time">Just now</span>`;
    messagesFeed.appendChild(msgDiv);
    messagesFeed.scrollTop = messagesFeed.scrollHeight;
  }

  function appendBotMessage(text) {
    const msgDiv = document.createElement('div');
    msgDiv.className = 'chat-message bot-message';
    msgDiv.innerHTML = `<div class="chat-bubble">${formatChatMessage(text)}</div><span class="chat-time">Just now</span>`;
    messagesFeed.appendChild(msgDiv);
    messagesFeed.scrollTop = messagesFeed.scrollHeight;
    return msgDiv;
  }

  function escapeHtml(str) {
    return str.replace(/[&<>"']/g, match => {
      const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
      return map[match];
    });
  }

  // Smart Demo Medical Intelligence Generator
  function getSmartDemoResponse(input) {
    const lower = input.toLowerCase();

    const inClinicTitle = window.careModelNames?.inClinic || 'In-Clinic Visit';
    const homeVisitTitle = window.careModelNames?.homeVisit || 'Home Visit';
    const telehealthTitle = window.careModelNames?.telehealth || 'E-Appointments';

    const clinicHoursText = window.practiceHoursConfig?.clinicHours || 'Mon - Sat: 10 AM - 2 PM';
    const telehealthHoursText = window.practiceHoursConfig?.telehealthHours || 'Mon - Sat: 2 PM - 7 PM';
    const sundayHoursText = window.practiceHoursConfig?.sundayHours || 'Sunday: Closed (E-Appointments Only)';

    if (lower.includes('hour') || lower.includes('time') || lower.includes('open') || lower.includes('schedule') || lower.includes('available')) {
      return `⏰ TELLinMedicine Practice Hours:\n\n• In-Clinic Hours:\n  🏥 ${inClinicTitle}: ${clinicHoursText}\n\n• Telehealth Hours:\n  💻 ${telehealthTitle}: ${telehealthHoursText}\n\n• Sunday Hours:\n  ${sundayHoursText}\n\nYou can inspect live time slots on our interactive calendar in the Working Hours section!`;
    }

    if (lower.includes('home') || lower.includes('visit') || lower.includes('house') || lower.includes('elderly') || lower.includes('mobility')) {
      return `🏥 ${homeVisitTitle}:\n\nDr. Jasper Ngomba provides comprehensive primary care doctor visits right in the comfort and security of your own home! Ideal for seniors, patients with mobility challenges, or busy individuals needing private home-based medical care in North Attleboro and surrounding Massachusetts communities.\n\nWould you like to book a ${homeVisitTitle} appointment?`;
    }

    if (lower.includes('vaccine') || lower.includes('travel') || lower.includes('shot') || lower.includes('immuniz') || lower.includes('abroad')) {
      return `✈️ Travel Vaccines & Global Health:\n\nPreparing for international travel? Dr. Ngomba offers destination-specific pre-travel health consultations, mandatory immunizations, and preventive prescriptions tailored to your itinerary.\n\nWe recommend booking your travel vaccine consult 4–6 weeks prior to departure!`;
    }

    const teleSettingLower = telehealthTitle.toLowerCase();
    if (lower.includes('tele') || lower.includes('virtual') || lower.includes('online') || lower.includes('video') || lower.includes('e-appointment') || lower.includes('e appointment') || lower.includes('eappointment') || (teleSettingLower && lower.includes(teleSettingLower))) {
      return `💻 ${telehealthTitle}:\n\nAccess Dr. Ngomba's medical expertise from anywhere in the world! ${telehealthTitle} are available (${telehealthHoursText}) via secure high-definition video care.\n\nYou can click "Start Virtual Visit" to book your session right now.`;
    }

    if (lower.includes('book') || lower.includes('appointment') || lower.includes('contact') || lower.includes('phone') || lower.includes('address') || lower.includes('location')) {
      return `📍 TELLinMedicine, LLC Contact Details:\n\n• Address: 380 Elm Street Suite 1, North Attleboro, MA 02760\n• Phone: (774) 643-6261 | (617) 513-1446\n• Email: tellinmedicinellc@gmail.com\n\nYou can also click the "Schedule Appointment" button on the page to open our 3-step booking wizard!`;
    }

    if (lower.includes('doctor') || lower.includes('ngomba') || lower.includes('who') || lower.includes('jasper') || lower.includes('background')) {
      return `👨‍⚕️ About Dr. Jasper I. Ngomba, MD:\n\nDr. Ngomba is Board-Certified in Internal Medicine and a former Critical Care Travel Nurse with decades of clinical experience in Massachusetts and Canada. He is affiliated with Steward Health Systems and is dedicated to preventive medicine: "Access to Health is Access to Wealth."`;
    }

    return `Thank you for contacting TELLinMedicine, LLC! Dr. Jasper I. Ngomba, MD and our team provide Adult Primary Care, ${homeVisitTitle}, Travel Medicine, and ${telehealthTitle}.\n\nHow can I assist you with your health today? Feel free to ask about clinic hours, home visits, travel vaccines, or scheduling an appointment.`;
  }

  chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const query = userInput.value.trim();
    if (!query) return;

    appendUserMessage(query);
    userInput.value = '';
    userInput.style.height = '40px';
    userInput.style.overflowY = 'hidden';

    const loadingDiv = appendBotMessage('⌛ TELLinCare Assist is typing...');

    try {
      const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
      const response = await fetch('/chat/message', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          message: query,
          history: conversationHistory
        })
      });

      const data = await response.json();
      if (data.success && data.reply) {
        loadingDiv.querySelector('.chat-bubble').innerText = data.reply;
        conversationHistory.push({ role: 'user', content: query });
        conversationHistory.push({ role: 'assistant', content: data.reply });
      } else {
        loadingDiv.querySelector('.chat-bubble').innerText = getSmartDemoResponse(query);
      }
    } catch (err) {
      console.warn('Chat endpoint network notice, using fallback response:', err);
      loadingDiv.querySelector('.chat-bubble').innerText = getSmartDemoResponse(query);
    }
  });
}

/* ==========================================================================
   Interactive 3D Clay Calendar & Inline Booking Inspector Logic
   ========================================================================== */

function initInteractiveCalendar() {
  const monthTitle = document.getElementById('calMonthTitle');
  const daysGrid = document.getElementById('calendarDaysGrid');
  const prevBtn = document.getElementById('prevMonthBtn');
  const nextBtn = document.getElementById('nextMonthBtn');

  const inspectorDateTitle = document.getElementById('inspectorDateTitle');
  const inspectorDayType = document.getElementById('inspectorDayType');
  const inspectorStatusIndicator = document.getElementById('inspectorStatusIndicator');

  const inlineForm = document.getElementById('inlineScheduleForm');
  const inlineDateInput = document.getElementById('inlineSelectedDate');
  const inlineCareInput = document.getElementById('inlineSelectedCareModel');
  const inlineTimeSelect = document.getElementById('inlineTimeSlotSelect');
  const inlineBtnDateText = document.getElementById('inlineBtnDateText');
  const inlineCareCards = document.querySelectorAll('.inline-care-card');

  if (!daysGrid) return;

  let currentDate = new Date();
  let selectedDate = new Date();

  const nowMidnight = new Date();
  nowMidnight.setHours(0, 0, 0, 0);

  // Care option cards click
  inlineCareCards.forEach(card => {
    card.addEventListener('click', () => {
      const val = card.getAttribute('data-value');
      selectInlineCareOption(val);
    });
  });

  function selectInlineCareOption(val) {
    inlineCareCards.forEach(c => c.classList.remove('selected'));
    let target = Array.from(inlineCareCards).find(c => c.getAttribute('data-value') === val || c.querySelector('.care-option-title')?.textContent?.trim() === val);
    if (!target) target = inlineCareCards[0];
    if (target) {
      target.classList.add('selected');
      val = target.getAttribute('data-value') || val;
    }
    if (inlineCareInput) inlineCareInput.value = val;
    updateInlineTimeSlots(selectedDate);
    handleHomeVisitEligibility(inlineForm);
  }

  function updateInlineTimeSlots(date) {
    if (!inlineTimeSelect) return;
    if (!date || !(date instanceof Date) || isNaN(date.getTime())) date = new Date();
    let selectedModel = inlineCareInput ? inlineCareInput.value : 'In-Clinic';
    const dayOfWeek = date.getDay(); // 0 = Sun
    const isSunday = dayOfWeek === 0;

    const inClinicLabel = window.careModelNames?.inClinic || 'In-Clinic';
    const homeLabel = window.careModelNames?.home || 'Home Visit';
    const telehealthLabel = window.careModelNames?.telehealth || 'E-Appointments';

    const isClinicOrHome = selectedModel === 'In-Clinic' || 
                           selectedModel === inClinicLabel || 
                           selectedModel === 'Home Visit' || 
                           selectedModel === homeLabel || 
                           selectedModel.toLowerCase().includes('home') || 
                           selectedModel.toLowerCase().includes('clinic');

    let hoursString = '';
    if (isSunday) {
      let sundaySetting = window.practiceHoursConfig?.sundayHours || '';
      let sundaySlots = parseTimeRangeToSlots(sundaySetting, 30);
      if (sundaySlots.length > 0) {
        hoursString = sundaySetting;
      } else {
        hoursString = window.practiceHoursConfig?.telehealthHours || '2 PM - 7 PM';
      }

      if (isClinicOrHome) {
        selectedModel = telehealthLabel;
        inlineCareCards.forEach(c => c.classList.remove('selected'));
        const target = inlineCareCards[2] || document.querySelector(`.inline-care-card[data-value="${telehealthLabel}"]`);
        if (target) target.classList.add('selected');
        if (inlineCareInput) inlineCareInput.value = telehealthLabel;
      }
    } else if (isClinicOrHome) {
      hoursString = window.practiceHoursConfig?.clinicHours || '';
    } else {
      hoursString = window.practiceHoursConfig?.telehealthHours || '';
    }

    let slots = parseTimeRangeToSlots(hoursString, 30);
    if (slots.length === 0) {
      slots = parseTimeRangeToSlots(window.practiceHoursConfig?.clinicHours || window.practiceHoursConfig?.telehealthHours || '10 AM - 2 PM', 30);
    }

    const currentVal = inlineTimeSelect.value;
    inlineTimeSelect.innerHTML = '';
    slots.forEach(slot => {
      const opt = document.createElement('option');
      opt.value = slot;
      opt.textContent = slot + ' (' + getCareModelLabel(selectedModel) + ')';
      if (slot === currentVal) opt.selected = true;
      inlineTimeSelect.appendChild(opt);
    });

    if (!inlineTimeSelect.value && slots.length > 0) {
      inlineTimeSelect.value = slots[0];
    }
  }

  function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    const monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ];

    monthTitle.textContent = `${monthNames[month]} ${year}`;
    daysGrid.innerHTML = '';

    const firstDayIndex = (new Date(year, month, 1).getDay() + 6) % 7; // Mon = 0
    const totalDaysInMonth = new Date(year, month + 1, 0).getDate();
    const prevMonthDays = new Date(year, month, 0).getDate();

    // Prev Month Fillers
    for (let i = firstDayIndex; i > 0; i--) {
      const dayNum = prevMonthDays - i + 1;
      const cell = document.createElement('div');
      cell.className = 'cal-day-cell is-other-month';
      cell.textContent = dayNum;
      daysGrid.appendChild(cell);
    }

    // Current Month Days
    for (let day = 1; day <= totalDaysInMonth; day++) {
      const cellDate = new Date(year, month, day);
      cellDate.setHours(0, 0, 0, 0);
      const dayOfWeek = cellDate.getDay(); // 0 = Sun

      const cell = document.createElement('div');
      cell.className = 'cal-day-cell';
      if (dayOfWeek === 0) cell.classList.add('is-sunday');

      if (cellDate < nowMidnight) {
        cell.classList.add('is-past-date');
      }

      if (cellDate.getTime() === nowMidnight.getTime()) {
        cell.classList.add('is-today');
      }

      if (cellDate.getTime() === selectedDate.getTime()) {
        cell.classList.add('is-selected');
      }

      cell.textContent = day;

      cell.addEventListener('click', (e) => {
        if (e) {
          e.preventDefault();
          e.stopPropagation();
        }
        if (cellDate < nowMidnight) {
          showThemeToast('Appointments cannot be booked for past dates. Please select today or a future date.', 'warning');
          return;
        }

        document.querySelectorAll('.cal-day-cell').forEach(c => c.classList.remove('is-selected'));
        cell.classList.add('is-selected');
        selectedDate = cellDate;
        updateSlotInspector(cellDate);
      });

      daysGrid.appendChild(cell);
    }
  }

  function updateSlotInspector(date) {
    const dayOfWeek = date.getDay(); // 0 = Sun
    const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const formattedDate = `${dayNames[dayOfWeek]}, ${monthNames[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
    if (inspectorDateTitle) inspectorDateTitle.textContent = formattedDate;
    if (inlineBtnDateText) inlineBtnDateText.textContent = `${monthNames[date.getMonth()]} ${date.getDate()}`;

    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    if (inlineDateInput) inlineDateInput.value = `${y}-${m}-${d}`;

    if (dayOfWeek === 0) { // Sunday
      if (inspectorDayType) {
        inspectorDayType.textContent = 'E-Appointment Only';
        inspectorDayType.style.background = 'var(--accent-purple-light)';
        inspectorDayType.style.color = 'var(--accent-purple)';
      }
      if (inspectorStatusIndicator) {
        inspectorStatusIndicator.textContent = '💻 Virtual Care Available';
        inspectorStatusIndicator.style.background = '#f3e8ff';
        inspectorStatusIndicator.style.color = '#7e22ce';
      }
    } else { // Mon-Sat
      if (inspectorDayType) {
        inspectorDayType.textContent = 'In-Clinic & Virtual';
        inspectorDayType.style.background = 'var(--primary-teal-light)';
        inspectorDayType.style.color = 'var(--primary-teal-dark)';
      }
      if (inspectorStatusIndicator) {
        inspectorStatusIndicator.textContent = '🟢 Open for Bookings';
        inspectorStatusIndicator.style.background = '#ecfdf5';
        inspectorStatusIndicator.style.color = '#10b981';
      }
    }

    updateInlineTimeSlots(date);
  }

  // Inline Form Submit
  if (inlineForm) {
    inlineForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const submitBtn = document.getElementById('inlineSubmitBtn');
      const originalText = submitBtn ? submitBtn.innerHTML : 'Confirm';

      const formData = new FormData(inlineForm);
      const otherReasonVal = formData.get('other_reason');
      const reasonVal = formData.get('reason');
      const finalReason = (otherReasonVal && otherReasonVal.trim() !== '') ? otherReasonVal.trim() : reasonVal;
      const patientAge = formData.get('patient_age');
      const isDisabled = formData.get('is_disabled') ? 1 : 0;
      const careModel = formData.get('care_model') || 'In-Clinic';

      if (careModel.toLowerCase().includes('home')) {
        const ageNum = parseInt(patientAge, 10) || 0;
        if (ageNum < 65 && !isDisabled) {
          showThemeToast('Physician Home Visits are exclusively available for patients aged 65 or older, or individuals with disabilities.', 'warning');
          return;
        }
      }

      const payload = {
        patient_name: formData.get('patient_name'),
        patient_phone: formData.get('patient_phone'),
        patient_email: formData.get('patient_email'),
        patient_age: patientAge ? parseInt(patientAge, 10) : null,
        is_disabled: isDisabled,
        appointment_date: formData.get('appointment_date'),
        time_slot: formData.get('time_slot'),
        care_model: careModel,
        reason: finalReason,
        other_reason: otherReasonVal ? otherReasonVal.trim() : '',
      };

      if (!payload.appointment_date) {
        showThemeAlert('Date Required', 'Please select a date on the calendar first.', 'info');
        return;
      }

      const apptDate = new Date(payload.appointment_date + 'T00:00:00');
      if (apptDate < nowMidnight) {
        showThemeToast('Appointments cannot be booked for past dates. Please select today or a future date.', 'warning');
        return;
      }

      const isSunday = apptDate.getDay() === 0;
      const careLower = careModel.toLowerCase();
      const teleSettingLower = (window.careModelNames?.telehealth || '').toLowerCase();
      const isTelehealth = careLower.includes('tele') || careLower.includes('e-appointment') || careLower.includes('e appointment') || careLower.includes('eappointment') || careLower.includes('virtual') || careLower.includes('online') || (teleSettingLower !== '' && careLower.includes(teleSettingLower));

      if (isSunday && !isTelehealth) {
        showThemeToast('The physical clinic and Home Visits are closed on Sundays. Please select E-Appointments for Sunday care.', 'warning');
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Requesting Appointment...';
      }

      fetch('/appointments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            showThemeAlert(
              'Appointment Request Submitted! 🎉',
              null,
              'success',
              `<div style="text-align: center; color: #475569;">
                <p style="font-size: 1.02rem; margin-bottom: 0.85rem;">${data.message}</p>
                <div style="background: #f0f9ff; padding: 12px 16px; border-radius: 10px; border: 1px solid #bae6fd; font-size: 0.88rem; color: #0369a1;">
                  📧 An email notification has been dispatched to <strong>Dr. Ngomba's team</strong>.
                </div>
              </div>`
            );
            inlineForm.reset();
            updateSlotInspector(selectedDate);
          } else {
            showThemeAlert('Notice', data.message || 'Validation error while submitting appointment.', 'error');
          }
        })
        .catch(err => {
          console.error('Inline schedule booking error:', err);
          showThemeAlert('Network Error', 'Could not process appointment request. Please verify network connection and try again.', 'error');
        })
        .finally(() => {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        });
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      if (e) e.preventDefault();
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar(currentDate);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      if (e) e.preventDefault();
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar(currentDate);
    });
  }

  selectedDate.setHours(0, 0, 0, 0);
  renderCalendar(currentDate);
  updateSlotInspector(selectedDate);
}

/* ==========================================================================
   Sequential IntersectionObserver Card Scroll Reveal
   ========================================================================== */

function initScrollReveal() {
  const revealTargetCards = document.querySelectorAll(
    '.pillar-card, .service-card, .gallery-card, .article-card, .calculator-card, .doctor-main-card, #contact .clay-card'
  );

  if (!revealTargetCards.length) return;

  revealTargetCards.forEach(card => card.classList.add('is-revealed'));

  if ('IntersectionObserver' in window) {
    const observerOptions = {
      root: null,
      rootMargin: '100px 0px 100px 0px',
      threshold: 0.01
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          obs.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealTargetCards.forEach(card => observer.observe(card));
  }
}

/* ==========================================================================
   Scroll Parallax Effect for Hero Section
   ========================================================================== */

function initScrollParallax() {
  const heroText = document.querySelector('.hero-text');
  const heroSyringe = document.querySelector('.hero-syringe-frame');
  const heroBadges = document.querySelectorAll('.hero-visual-stage .floating-3d-element');

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;

    if (scrollY < 850) {
      if (heroText) {
        heroText.style.transform = `translate3d(0, ${scrollY * 0.2}px, 0)`;
        heroText.style.opacity = `${Math.max(0, 1 - scrollY / 600)}`;
      }

      if (heroSyringe) {
        heroSyringe.style.transform = `translate3d(0, ${scrollY * 0.3}px, 0) rotate(${-15 + scrollY * 0.015}deg)`;
      }

      heroBadges.forEach((badge, idx) => {
        const speed = (idx + 1) * 0.12;
        badge.style.transform = `translate3d(0, ${scrollY * speed}px, 0)`;
      });
    }
  });
}

/* ==========================================================================
   1. Booking Modal & Care Wizard Logic
   ========================================================================== */

function initBookingModal() {
  const modalBackdrop = document.getElementById('bookingModal');
  const openBtns = document.querySelectorAll('.js-open-booking');
  const closeBtn = document.getElementById('closeModal');
  const bookingForm = document.getElementById('bookingForm');
  const careCards = document.querySelectorAll('.care-option-card');
  const selectedCareInput = document.getElementById('selectedCareModel');
  const dateInput = document.getElementById('bookDate');
  const timeSlotSelect = document.getElementById('timeSlotSelect');

  if (!modalBackdrop) return;

  const todayObj = new Date();
  const todayStr = todayObj.toISOString().split('T')[0];
  if (dateInput && !dateInput.value) {
    dateInput.value = todayStr;
  }

  function updateTimeSlotOptions() {
    if (!timeSlotSelect) return;
    let selectedModel = selectedCareInput ? selectedCareInput.value : 'In-Clinic';
    const dateVal = dateInput ? dateInput.value : todayStr;
    let dObj = dateVal ? new Date(dateVal + 'T00:00:00') : new Date();
    if (isNaN(dObj.getTime())) dObj = new Date();
    const isSunday = dObj.getDay() === 0;

    const inClinicLabel = window.careModelNames?.inClinic || 'In-Clinic';
    const homeLabel = window.careModelNames?.home || 'Home Visit';
    const telehealthLabel = window.careModelNames?.telehealth || 'E-Appointments';

    const isClinicOrHome = selectedModel === 'In-Clinic' || 
                           selectedModel === inClinicLabel || 
                           selectedModel === 'Home Visit' || 
                           selectedModel === homeLabel || 
                           selectedModel.toLowerCase().includes('home') || 
                           selectedModel.toLowerCase().includes('clinic');

    let hoursString = '';
    if (isSunday) {
      let sundaySetting = window.practiceHoursConfig?.sundayHours || '';
      let sundaySlots = parseTimeRangeToSlots(sundaySetting, 30);
      if (sundaySlots.length > 0) {
        hoursString = sundaySetting;
      } else {
        hoursString = window.practiceHoursConfig?.telehealthHours || '2 PM - 7 PM';
      }

      if (isClinicOrHome) {
        selectedModel = telehealthLabel;
        careCards.forEach(c => c.classList.remove('selected'));
        const target = careCards[2] || document.querySelector(`.care-option-card[data-value="${telehealthLabel}"]`);
        if (target) target.classList.add('selected');
        if (selectedCareInput) selectedCareInput.value = telehealthLabel;
      }
    } else if (isClinicOrHome) {
      hoursString = window.practiceHoursConfig?.clinicHours || '';
    } else {
      hoursString = window.practiceHoursConfig?.telehealthHours || '';
    }

    let slots = parseTimeRangeToSlots(hoursString, 30);
    if (slots.length === 0) {
      slots = parseTimeRangeToSlots(window.practiceHoursConfig?.clinicHours || window.practiceHoursConfig?.telehealthHours || '10 AM - 2 PM', 30);
    }

    const currentVal = timeSlotSelect.value;
    timeSlotSelect.innerHTML = '';
    slots.forEach(slot => {
      const opt = document.createElement('option');
      opt.value = slot;
      opt.textContent = slot + ' (' + getCareModelLabel(selectedModel) + ')';
      if (slot === currentVal) opt.selected = true;
      timeSlotSelect.appendChild(opt);
    });

    if (!timeSlotSelect.value && slots.length > 0) {
      timeSlotSelect.value = slots[0];
    }
  }

  if (dateInput) {
    dateInput.addEventListener('change', () => {
      if (!dateInput.value) return;
      const selected = new Date(dateInput.value + 'T00:00:00');
      const nowMidnight = new Date();
      nowMidnight.setHours(0, 0, 0, 0);

      if (selected < nowMidnight) {
        showThemeToast('Appointments cannot be booked for past dates. Please select today or a future date.', 'warning');
        dateInput.value = todayStr;
      }
      updateTimeSlotOptions();
    });
  }

  careCards.forEach(card => {
    card.addEventListener('click', () => {
      const val = card.getAttribute('data-value');
      selectCareOption(val);
    });
  });

  function selectCareOption(val) {
    careCards.forEach(c => c.classList.remove('selected'));
    let target = Array.from(careCards).find(c => c.getAttribute('data-value') === val || c.querySelector('.care-option-title')?.textContent?.trim() === val);
    if (!target) target = careCards[0];
    if (target) {
      target.classList.add('selected');
      val = target.getAttribute('data-value') || val;
    }
    if (selectedCareInput) selectedCareInput.value = val;
    updateTimeSlotOptions();
    handleHomeVisitEligibility(bookingForm);
  }

  window.openBookingModal = function (dateObj, timeSlot, careModel) {
    if (dateObj) {
      const nowMidnight = new Date();
      nowMidnight.setHours(0, 0, 0, 0);
      const testDate = new Date(dateObj);
      testDate.setHours(0, 0, 0, 0);

      if (testDate < nowMidnight) {
        showThemeToast('Appointments cannot be booked for past dates. Please select a future date.', 'warning');
        return;
      }
      const y = dateObj.getFullYear();
      const m = String(dateObj.getMonth() + 1).padStart(2, '0');
      const d = String(dateObj.getDate()).padStart(2, '0');
      if (dateInput) dateInput.value = `${y}-${m}-${d}`;
    }
    if (careModel) {
      selectCareOption(careModel);
    } else {
      updateTimeSlotOptions();
    }
    if (timeSlot && timeSlotSelect) {
      timeSlotSelect.value = timeSlot;
    }
    modalBackdrop.classList.add('active');
  };

  openBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const preselect = btn.getAttribute('data-care-model');
      window.openBookingModal(null, null, preselect || 'In-Clinic');
    });
  });

  const closeModalFunc = () => {
    modalBackdrop.classList.remove('active');
  };

  if (closeBtn) closeBtn.addEventListener('click', closeModalFunc);

  modalBackdrop.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) closeModalFunc();
  });

  if (bookingForm) {
    bookingForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const submitBtn = document.getElementById('submitBookingBtn') || bookingForm.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.textContent : 'Confirm';

      const formData = new FormData(bookingForm);
      const otherReasonVal = formData.get('other_reason');
      const reasonVal = formData.get('reason');
      const finalReason = (otherReasonVal && otherReasonVal.trim() !== '') ? otherReasonVal.trim() : reasonVal;
      const patientAge = formData.get('patient_age');
      const isDisabled = formData.get('is_disabled') ? 1 : 0;
      const careModel = formData.get('care_model') || 'In-Clinic';

      if (careModel.toLowerCase().includes('home')) {
        const ageNum = parseInt(patientAge, 10) || 0;
        if (ageNum < 65 && !isDisabled) {
          showThemeToast('Physician Home Visits are exclusively available for patients aged 65 or older, or individuals with disabilities.', 'warning');
          return;
        }
      }

      const payload = {
        patient_name: formData.get('patient_name'),
        patient_phone: formData.get('patient_phone'),
        patient_email: formData.get('patient_email'),
        patient_age: patientAge ? parseInt(patientAge, 10) : null,
        is_disabled: isDisabled,
        appointment_date: formData.get('appointment_date'),
        time_slot: formData.get('time_slot'),
        care_model: careModel,
        reason: finalReason,
        other_reason: otherReasonVal ? otherReasonVal.trim() : '',
      };

      if (payload.appointment_date) {
        const apptDate = new Date(payload.appointment_date + 'T00:00:00');
        const nowMidnight = new Date();
        nowMidnight.setHours(0, 0, 0, 0);
        if (apptDate < nowMidnight) {
          showThemeToast('Appointments cannot be booked for past dates. Please select today or a future date.', 'warning');
          return;
        }

        const isSunday = apptDate.getDay() === 0;
        const careLower = careModel.toLowerCase();
        const teleSettingLower = (window.careModelNames?.telehealth || '').toLowerCase();
        const isTelehealth = careLower.includes('tele') || careLower.includes('e-appointment') || careLower.includes('e appointment') || careLower.includes('eappointment') || careLower.includes('virtual') || careLower.includes('online') || (teleSettingLower !== '' && careLower.includes(teleSettingLower));

        if (isSunday && !isTelehealth) {
          showThemeToast('The physical clinic and Home Visits are closed on Sundays. Please select E-Appointments for Sunday care.', 'warning');
          return;
        }
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = '⏳ Submitting Request...';
      }

      fetch('/appointments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            showThemeAlert(
              'Appointment Request Submitted! 🎉',
              null,
              'success',
              `<div style="text-align: center; color: #475569;">
                <p style="font-size: 1.02rem; margin-bottom: 0.85rem;">${data.message}</p>
                <div style="background: #f0f9ff; padding: 12px 16px; border-radius: 10px; border: 1px solid #bae6fd; font-size: 0.88rem; color: #0369a1;">
                  📧 An email notification has been dispatched to <strong>Dr. Ngomba's team</strong>.
                </div>
              </div>`
            );
            bookingForm.reset();
            if (dateInput) dateInput.value = todayStr;
            closeModalFunc();
          } else {
            showThemeAlert('Notice', data.message || 'Validation error while submitting appointment.', 'error');
          }
        })
        .catch(err => {
          console.error('Booking submission error:', err);
          showThemeAlert('Network Error', 'Could not process appointment request. Please verify network connection and try again.', 'error');
        })
        .finally(() => {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
          }
        });
    });
  }

  updateTimeSlotOptions();
}

/* ==========================================================================
   2. Interactive BMI & Diabetes Risk Calculator
   ========================================================================== */

function initBMICalculator() {
  const calcForm = document.getElementById('bmiCalcForm');
  const bmiScoreEl = document.getElementById('bmiScore');
  const bmiCategoryEl = document.getElementById('bmiCategory');
  const riskAssessmentEl = document.getElementById('riskAssessment');

  if (!calcForm) return;

  calcForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const weightKg = parseFloat(document.getElementById('calcWeight').value);
    const heightCm = parseFloat(document.getElementById('calcHeight').value);
    const age = parseInt(document.getElementById('calcAge').value) || 30;

    if (!weightKg || !heightCm || weightKg <= 0 || heightCm <= 0) {
      showThemeAlert('Invalid Values', 'Please enter valid height and weight values to calculate your BMI.', 'info');
      return;
    }

    const heightM = heightCm / 100;
    const bmi = (weightKg / (heightM * heightM)).toFixed(1);

    bmiScoreEl.textContent = bmi;

    let category = '';
    let categoryColor = '#1A84C5';
    let riskText = '';

    if (bmi < 18.5) {
      category = 'Underweight';
      categoryColor = '#f7b731';
      riskText = 'Consult Dr. Ngomba about balanced nutritional primary care.';
    } else if (bmi >= 18.5 && bmi < 25) {
      category = 'Healthy Weight';
      categoryColor = '#2ed573';
      riskText = 'Optimal healthy range! Continue your preventive wellness routine.';
    } else if (bmi >= 25 && bmi < 30) {
      category = 'Overweight';
      categoryColor = '#ff7f50';
      riskText = 'Slightly elevated risk. Lifestyle & dietary adjustments recommended.';
    } else {
      category = 'Obesity Category';
      categoryColor = '#ff4757';
      riskText = 'Elevated risk for diabetes & hypertension. Schedule a consultation with Dr. Ngomba.';
    }

    if (age > 45 && bmi >= 25) {
      riskText += ' (Note: Diabetes screening recommended for adults over 45).';
    }

    bmiCategoryEl.textContent = category;
    bmiCategoryEl.style.color = categoryColor;
    riskAssessmentEl.textContent = riskText;
  });
}

/* ==========================================================================
   3. Service Tabs Filtering
   ========================================================================== */

function initServiceTabs() {
  const tabBtns = document.querySelectorAll('.tab-btn');
  const serviceCards = document.querySelectorAll('.service-card');

  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tabBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');

      serviceCards.forEach(card => {
        if (filter === 'all' || card.getAttribute('data-category') === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}

/* ==========================================================================
   4. Floating 3D Parallax Motion Effect
   ========================================================================== */

function init3DParallax() {
  const floatingElements = document.querySelectorAll('.floating-3d-element');

  window.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX / window.innerWidth - 0.5;
    const mouseY = e.clientY / window.innerHeight - 0.5;

    floatingElements.forEach((el, idx) => {
      const speed = (idx + 1) * 18;
      const x = mouseX * speed;
      const y = mouseY * speed;
      el.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    });
  });
}

/* ==========================================================================
   5. Dynamic Practice Live Care Hours Status
   ========================================================================== */

function initPracticeStatus() {
  const statusValEl = document.getElementById('liveStatusVal');

  const now = new Date();
  const day = now.getDay(); // 0 is Sunday
  const hour = now.getHours();

  // Highlight today's row in Working Hours table
  const todayRow = document.querySelector(`.hours-row[data-day="${day}"]`);
  if (todayRow) {
    todayRow.classList.add('is-today');
  }

  if (!statusValEl) return;

  if (day === 0) {
    statusValEl.textContent = 'E-Appointments Only (Sunday)';
    statusValEl.style.color = '#705ec8';
  } else if (hour >= 8 && hour < 12) {
    statusValEl.textContent = 'In-Clinic Open Now (8 AM - 12 PM)';
    statusValEl.style.color = '#2ed573';
  } else if (hour >= 12 && hour < 18) {
    statusValEl.textContent = 'Virtual Telehealth Open (12 PM - 6 PM)';
    statusValEl.style.color = '#1A84C5';
  } else {
    statusValEl.textContent = 'After Hours (Request Online Callback)';
    statusValEl.style.color = '#ff7f50';
  }
}

/* ==========================================================================
   6. Dropdown Select Option Redirect Link Handler
   ========================================================================== */
document.addEventListener('change', function(e) {
  if (e.target && e.target.classList.contains('redirect-option-select')) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    if (selectedOption) {
      const redirectUrl = selectedOption.getAttribute('data-redirect-url');
      if (redirectUrl && redirectUrl.trim() !== '') {
        let targetUrl = redirectUrl.trim();
        if (!targetUrl.startsWith('/') && !targetUrl.startsWith('http://') && !targetUrl.startsWith('https://')) {
          targetUrl = 'https://' + targetUrl;
        }
        window.open(targetUrl, '_blank');
      }
    }
  }

  // Handle 'Other' option dynamic custom text input field display
  if (e.target && e.target.classList.contains('reason-select-box')) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    const val = (e.target.value || '').toLowerCase();
    const label = (selectedOption ? selectedOption.text : '').toLowerCase();

    const form = e.target.closest('form');
    if (form) {
      const otherWrapper = form.querySelector('.other-reason-wrapper');
      const otherInput = form.querySelector('.other-reason-input');

      if (val === 'other' || label.includes('other')) {
        if (otherWrapper) otherWrapper.style.display = 'block';
        if (otherInput) {
          otherInput.setAttribute('required', 'required');
          otherInput.focus();
        }
      } else {
        if (otherWrapper) otherWrapper.style.display = 'none';
        if (otherInput) {
          otherInput.removeAttribute('required');
          otherInput.value = '';
        }
      }
    }
  }

  // Handle Home Visit eligibility input updates
  if (e.target && (e.target.classList.contains('home-visit-age-input') || e.target.classList.contains('home-visit-disabled-check'))) {
    const form = e.target.closest('form');
    if (form) handleHomeVisitEligibility(form);
  }
});

document.addEventListener('input', function(e) {
  if (e.target && (e.target.classList.contains('home-visit-age-input') || e.target.classList.contains('home-visit-disabled-check'))) {
    const form = e.target.closest('form');
    if (form) handleHomeVisitEligibility(form);
  }
});
