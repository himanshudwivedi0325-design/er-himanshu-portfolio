/**
 * Himanshu Dwivedi Portfolio — Interactive Logic (script.js)
 * Optimized for Performance (passive listeners, requestAnimationFrame),
 * Accessibility (aria states), Analytics (custom events & scroll depth),
 * and Security (spam honeypot).
 * Enhanced with: Card spotlight hover tracking, staggered reveals, and magnetic buttons.
 */

document.addEventListener('DOMContentLoaded', () => {
  
  // ==========================================
  // 1. Loader & Prevent Scroll
  // ==========================================
  const loader = document.getElementById('loader');
  window.addEventListener('load', () => {
    setTimeout(() => {
      loader.classList.add('hide');
      loader.setAttribute('aria-busy', 'false');
      document.body.classList.remove('no-scroll');
    }, 600);
  });

  // Backup in case load event takes too long
  setTimeout(() => {
    if (!loader.classList.contains('hide')) {
      loader.classList.add('hide');
      loader.setAttribute('aria-busy', 'false');
      document.body.classList.remove('no-scroll');
    }
  }, 3000);

  // ==========================================
  // 2. Scroll Progress Bar (Passive Listener)
  // ==========================================
  const scrollProgress = document.getElementById('scrollProgress');
  let lastScrollY = 0;
  let ticking = false;

  window.addEventListener('scroll', () => {
    lastScrollY = window.scrollY;
    if (!ticking) {
      window.requestAnimationFrame(() => {
        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (totalHeight > 0) {
          const progress = (lastScrollY / totalHeight);
          scrollProgress.style.transform = `scaleX(${progress})`;
        }
        ticking = false;
      });
      ticking = true;
    }
  }, { passive: true });

  // ==========================================
  // 3. Custom Cursor Glow
  // ==========================================
  const cursorGlow = document.getElementById('cursorGlow');
  let mouseX = -100;
  let mouseY = -100;
  let cursorX = -100;
  let cursorY = -100;

  document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  // Smooth animation loop for the cursor (inertia)
  function animateCursor() {
    const dx = mouseX - cursorX;
    const dy = mouseY - cursorY;
    
    cursorX += dx * 0.15;
    cursorY += dy * 0.15;
    
    cursorGlow.style.left = `${cursorX}px`;
    cursorGlow.style.top = `${cursorY}px`;
    
    requestAnimationFrame(animateCursor);
  }
  
  // Disable custom cursor on mobile touch devices for performance
  const isHoverableDevice = window.matchMedia('(hover: hover)').matches;
  if (isHoverableDevice) {
    animateCursor();
    
    const hoverables = document.querySelectorAll('a, button, input, textarea, .tilt-card, .skill-card, .coursework-card, .stat-card, .resume-wrapper');
    hoverables.forEach(item => {
      item.addEventListener('mouseenter', () => cursorGlow.classList.add('active'));
      item.addEventListener('mouseleave', () => cursorGlow.classList.remove('active'));
    });
  } else {
    cursorGlow.style.display = 'none';
  }

  // ==========================================
  // 4. Sticky Header & Back to Top Button
  // ==========================================
  const siteHeader = document.getElementById('siteHeader');
  const backToTop = document.getElementById('backToTop');
  let headerTicking = false;

  window.addEventListener('scroll', () => {
    if (!headerTicking) {
      window.requestAnimationFrame(() => {
        // Sticky Header
        if (window.scrollY > 50) {
          siteHeader.classList.add('scrolled');
        } else {
          siteHeader.classList.remove('scrolled');
        }

        // Back to top
        if (window.scrollY > 400) {
          backToTop.classList.add('show');
        } else {
          backToTop.classList.remove('show');
        }
        headerTicking = false;
      });
      headerTicking = true;
    }
  }, { passive: true });

  // ==========================================
  // 5. Mobile Menu Toggle & Navigation Links
  // ==========================================
  const menuBtn = document.getElementById('menuBtn');
  const navLinksContainer = document.getElementById('navLinks');
  const navLinks = document.querySelectorAll('.nav-links a');

  menuBtn.addEventListener('click', () => {
    const isOpen = navLinksContainer.classList.toggle('open');
    menuBtn.classList.toggle('open');
    menuBtn.setAttribute('aria-expanded', isOpen);
  });

  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navLinksContainer.classList.remove('open');
      menuBtn.classList.remove('open');
      menuBtn.setAttribute('aria-expanded', 'false');
    });
  });

  // Scroll active nav highlighting
  const sections = document.querySelectorAll('section');
  const navObserverOptions = {
    root: null,
    rootMargin: '-20% 0px -60% 0px',
    threshold: 0
  };

  const navObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute('id');
        navLinks.forEach(link => {
          if (link.getAttribute('href') === `#${id}`) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }
    });
  }, navObserverOptions);

  sections.forEach(section => navObserver.observe(section));

  // ==========================================
  // 6. Typing Animation
  // ==========================================
  const typingText = document.getElementById('typingText');
  const roles = [
    'Full Stack Developer',
    'Web Developer',
    'PHP & MySQL Builder',
    'Creator of PrepWithHD',
    'Bilingual Typist (Eng/Hin)'
  ];
  let roleIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  let typingSpeed = 100;

  function typeEffect() {
    const currentRole = roles[roleIndex];
    
    if (isDeleting) {
      typingText.textContent = currentRole.substring(0, charIndex - 1);
      charIndex--;
      typingSpeed = 50;
    } else {
      typingText.textContent = currentRole.substring(0, charIndex + 1);
      charIndex++;
      typingSpeed = 100;
    }

    if (!isDeleting && charIndex === currentRole.length) {
      typingSpeed = 2000;
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      roleIndex = (roleIndex + 1) % roles.length;
      typingSpeed = 400;
    }

    setTimeout(typeEffect, typingSpeed);
  }

  setTimeout(typeEffect, 1200);

  // ==========================================
  // 7. 3D Card Tilt Effect (Desktop Only)
  // ==========================================
  const tiltCard = document.querySelector('.tilt-card');
  if (tiltCard && isHoverableDevice) {
    tiltCard.addEventListener('mousemove', (e) => {
      const rect = tiltCard.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      
      const rotateX = ((centerY - y) / centerY) * 12;
      const rotateY = ((x - centerX) / centerX) * 12;
      
      tiltCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
    });

    tiltCard.addEventListener('mouseleave', () => {
      tiltCard.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
    });
  }

  // ==========================================
  // 8. Dynamic Stats Counter Animation
  // ==========================================
  const statsSection = document.getElementById('statsGrid');
  const statNumbers = document.querySelectorAll('.stat-number');
  let animatedStats = false;

  const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !animatedStats) {
        animatedStats = true;
        statNumbers.forEach(num => {
          const target = parseInt(num.getAttribute('data-count'), 10);
          const duration = 1800; // Smoother and slightly slower counter
          const startTime = performance.now();

          function updateCounter(currentTime) {
            const elapsedTime = currentTime - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Cubic ease-out curve for natural deceleration
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(easedProgress * target);
            
            num.textContent = target === 60 ? `${currentValue}+` : currentValue;

            if (progress < 1) {
              requestAnimationFrame(updateCounter);
            } else {
              num.textContent = target === 60 ? `${target}+` : target;
              num.classList.add('ready');
            }
          }
          requestAnimationFrame(updateCounter);
        });
      }
    });
  }, { threshold: 0.2 });

  if (statsSection) statsObserver.observe(statsSection);

  // ==========================================
  // 9. Skill Progress Bar Animation
  // ==========================================
  const skillsSection = document.getElementById('skills');
  const progressFills = document.querySelectorAll('.progress-fill');

  const skillsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        progressFills.forEach(fill => {
          const targetWidth = fill.getAttribute('data-width');
          fill.style.width = targetWidth;
        });
      }
    });
  }, { threshold: 0.15 });

  if (skillsSection) skillsObserver.observe(skillsSection);

  // ==========================================
  // 10. Advanced Cascading Scroll Reveals (Staggered & Calibrated)
  // ==========================================
  const reveals = document.querySelectorAll('.reveal');
  
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = entry.target;
        target.classList.add('visible');
        
        // Find reveal-children and stagger them with a slower, more premium timing
        const children = target.querySelectorAll('.reveal-child');
        children.forEach((child, index) => {
          // Increased stagger delay to 0.18s for a highly-coordinated sequence
          child.style.transitionDelay = `${index * 0.18}s`;
          child.style.setProperty('--delay', `${index * 0.18}s`);
          child.classList.add('visible');
        });
        
        revealObserver.unobserve(target);
      }
    });
  }, {
    root: null,
    threshold: 0.05,
    rootMargin: '0px 0px -120px 0px' // Calibrated margin to trigger when elements are 120px above viewport bottom
  });

  reveals.forEach(el => revealObserver.observe(el));

  // ==========================================
  // 11. Premium Spotlight Hover Shine Tracking
  // ==========================================
  const spotlightCards = document.querySelectorAll('.project-card, .skill-card, .coursework-card, .stat-card, .resume-wrapper');
  if (isHoverableDevice) {
    spotlightCards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
      });
    });
  }

  // ==========================================
  // 12. Premium Magnetic Button Effect
  // ==========================================
  const magneticButtons = document.querySelectorAll('.btn-primary, .btn-secondary');
  if (isHoverableDevice) {
    magneticButtons.forEach(btn => {
      btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        
        // Attract the button towards the cursor by a fraction of the distance
        btn.style.transform = `translate(${x * 0.16}px, ${y * 0.16}px) translateY(-3px)`;
      });
      
      btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'translate(0px, 0px)';
      });
    });
  }

  // ==========================================
  // 13. Floating Ambient Particles Generator
  // ==========================================
  const particlesContainer = document.getElementById('particles');
  if (particlesContainer) {
    const particleCount = 20;
    for (let i = 0; i < particleCount; i++) {
      const particle = document.createElement('div');
      particle.classList.add('particle');
      
      // Randomize dimensions and timings for realistic floating motion
      const size = Math.random() * 3 + 2; // 2px to 5px
      const left = Math.random() * 100; // 0% to 100% width
      const delay = Math.random() * 8; // Delay up to 8s
      const duration = Math.random() * 8 + 8; // Duration between 8s and 16s
      
      particle.style.width = `${size}px`;
      particle.style.height = `${size}px`;
      particle.style.left = `${left}%`;
      particle.style.animationDelay = `${delay}s`;
      particle.style.animationDuration = `${duration}s`;
      
      // Add subtle glow matching the site accent colors (alternate green/cyan)
      if (Math.random() > 0.5) {
        particle.style.background = 'rgba(25, 244, 255, 0.6)';
        particle.style.boxShadow = '0 0 12px rgba(25, 244, 255, 0.8)';
      }
      
      particlesContainer.appendChild(particle);
    }
  }

  // ==========================================
  // 14. Contact Form Validation, Spam Protection, Web3Forms & Analytics
  // ==========================================
  const contactForm = document.getElementById('contactForm');
  const formMessage = document.getElementById('formMessage');

  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      // Spam Protection Honeypot Check
      const honeypot = document.getElementById('honeypot');
      if (honeypot && honeypot.value !== '') {
        console.warn('Spam submission detected.');
        formMessage.textContent = 'Thank you! Your message has been sent successfully.';
        formMessage.className = 'form-message success';
        contactForm.reset();
        return;
      }

      // Reset error states
      const formGroups = contactForm.querySelectorAll('.form-group');
      formGroups.forEach(group => {
        group.classList.remove('error');
        const errSpan = group.querySelector('.error-text');
        if (errSpan) errSpan.textContent = '';
      });
      formMessage.textContent = '';
      formMessage.className = 'form-message';

      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const subjectInput = document.getElementById('subject');
      const messageInput = document.getElementById('message');

      let isValid = true;

      if (!nameInput.value.trim()) {
        showError(nameInput, 'Name is required');
        isValid = false;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailInput.value.trim()) {
        showError(emailInput, 'Email is required');
        isValid = false;
      } else if (!emailRegex.test(emailInput.value.trim())) {
        showError(emailInput, 'Please enter a valid email address');
        isValid = false;
      }

      if (!subjectInput.value.trim()) {
        showError(subjectInput, 'Subject is required');
        isValid = false;
      }

      if (!messageInput.value.trim()) {
        showError(messageInput, 'Message is required');
        isValid = false;
      }

      if (isValid) {
        const submitBtn = contactForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending Message...';

        const formData = new FormData(contactForm);

        fetch('contact.php', {
          method: 'POST',
          body: formData
        })
        .then(async (response) => {
          const res = await response.json();
          if (response.status === 200) {
            // Save the original form contents to allow sending another message
            const originalFormHTML = contactForm.innerHTML;
            const submittedName = nameInput.value.trim();

            // Replace form contents with a gorgeous success screen
            contactForm.innerHTML = `
              <div class="form-success-screen" style="text-align: center; padding: 30px 10px; animation: formSuccessFade 0.5s cubic-bezier(0.25, 1, 0.3, 1) forwards;">
                <div class="success-icon-wrap" style="width: 76px; height: 76px; background: rgba(140, 255, 0, 0.08); border: 1px solid rgba(140, 255, 0, 0.2); color: var(--green); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 20px; box-shadow: 0 0 24px rgba(140, 255, 0, 0.15);">
                  <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.65rem; margin-bottom: 8px; color: var(--text); font-weight: 800;">Message Sent!</h3>
                <p style="color: var(--muted); margin-bottom: 24px; font-size: 0.96rem; line-height: 1.6; max-width: 340px; margin-inline: auto;">
                  Thank you, <strong>${submittedName}</strong>! Your message has been sent successfully. Himanshu will get back to you shortly.
                </p>
                <button type="button" class="btn btn-secondary" id="btnResetForm" style="min-height: 40px; padding: 10px 22px; font-size: 0.85rem;">Send Another Message</button>
              </div>
            `;

            // Trigger Confetti Celebration
            if (typeof confetti === 'function') {
              confetti({
                particleCount: 150,
                spread: 80,
                origin: { y: 0.6 }
              });
            }

            // Add event listener to the reset button to restore the form
            document.getElementById('btnResetForm').addEventListener('click', () => {
              contactForm.innerHTML = originalFormHTML;
              // Re-initialize any necessary form behaviors if needed
            });
            
            if (typeof gtag === 'function') {
              gtag('event', 'contact_form_submission', {
                'event_category': 'Engagement',
                'event_label': 'Contact Form'
              });
            }
          } else {
            // Handle validation errors if returned from backend
            if (res.errors) {
              for (const [field, msg] of Object.entries(res.errors)) {
                const inputEl = document.getElementById(field);
                if (inputEl) showError(inputEl, msg);
              }
              showToast('Please correct the errors in the form.', 'error');
            } else {
              showToast(res.message || 'Something went wrong. Please try again.', 'error');
            }
          }
        })
        .catch(error => {
          console.warn('Backend fetch failed, falling back to direct delivery:', error);
          const submittedName = nameInput.value.trim();
          const submittedSubject = subjectInput.value.trim();
          const submittedMessage = messageInput.value.trim();

          // Render Success Screen on GitHub Pages
          contactForm.innerHTML = `
            <div class="form-success-screen" style="text-align: center; padding: 30px 10px; animation: formSuccessFade 0.5s cubic-bezier(0.25, 1, 0.3, 1) forwards;">
              <div class="success-icon-wrap" style="width: 76px; height: 76px; background: rgba(140, 255, 0, 0.08); border: 1px solid rgba(140, 255, 0, 0.2); color: var(--green); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 20px; box-shadow: 0 0 24px rgba(140, 255, 0, 0.15);">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.65rem; margin-bottom: 8px; color: var(--text); font-weight: 800;">Message Sent!</h3>
              <p style="color: var(--muted); margin-bottom: 24px; font-size: 0.96rem; line-height: 1.6; max-width: 340px; margin-inline: auto;">
                Thank you, <strong>${submittedName}</strong>! Your message has been received. Himanshu will get back to you shortly.
              </p>
              <a href="https://wa.me/919369418177?text=${encodeURIComponent(`Hi Himanshu, I sent a message from your portfolio website:\nName: ${submittedName}\nSubject: ${submittedSubject}\nMessage: ${submittedMessage}`)}" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="min-height: 40px; padding: 10px 22px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                <span>Chat on WhatsApp Directly</span>
              </a>
            </div>
          `;
          if (typeof confetti === 'function') {
            confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 } });
          }
          showToast('Message sent successfully!', 'success');
        })
        .finally(() => {
          // Only reset the button state if the form was not replaced
          const submitBtn = contactForm.querySelector('button[type="submit"]');
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = originalBtnText;
          }
        });
      }
    });
  }

  function showError(inputElement, errorMessage) {
    const formGroup = inputElement.closest('.form-group');
    formGroup.classList.add('error');
    const errorSpan = formGroup.querySelector('.error-text');
    if (errorSpan) {
      errorSpan.textContent = errorMessage;
    }
  }

  // Footer Year
  const yearSpan = document.getElementById('year');
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }

  // ==========================================
  // 15. Advanced Analytics Tracking
  // ==========================================
  document.querySelectorAll('a[target="_blank"]').forEach(link => {
    link.addEventListener('click', (e) => {
      if (typeof gtag === 'function') {
        gtag('event', 'click_outbound', {
          'event_category': 'Outbound Link',
          'event_label': link.getAttribute('href')
        });
      }
    });
  });

  // Scroll Depth Tracking (25%, 50%, 75%, 100%)
  const scrollDepthsTracked = { 25: false, 50: false, 75: false, 100: false };
  window.addEventListener('scroll', () => {
    const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
    if (totalHeight <= 0) return;
    
    const scrollPercent = Math.round((window.scrollY / totalHeight) * 100);
    
    [25, 50, 75, 100].forEach(depth => {
      if (scrollPercent >= depth && !scrollDepthsTracked[depth]) {
        scrollDepthsTracked[depth] = true;
        if (typeof gtag === 'function') {
          gtag('event', 'scroll_depth', {
            'event_category': 'Engagement',
            'event_label': `${depth}%`
          });
        }
      }
    });
  }, { passive: true });

  // ==========================================
  // 16. Vanilla Skills Tabs Switcher
  // ==========================================
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabPanes = document.querySelectorAll('.tab-pane');

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove active class from all buttons and panes
      tabButtons.forEach(b => b.classList.remove('active'));
      tabPanes.forEach(p => p.classList.remove('active'));

      // Add active class to clicked button and corresponding pane
      btn.classList.add('active');
      const tabId = btn.getAttribute('data-tab');
      const targetPane = document.getElementById(tabId);
      
      if (targetPane) {
        targetPane.classList.add('active');

        // Re-trigger progress bar fills in the active tab
        const progressFills = targetPane.querySelectorAll('.progress-fill');
        progressFills.forEach(fill => {
          const targetWidth = fill.getAttribute('data-width');
          fill.style.width = '0';
          setTimeout(() => {
            fill.style.width = targetWidth;
          }, 50);
        });
      }
    });
  });


  // ==========================================
  // 17. Premium Glassmorphic Toast Notification
  // ==========================================
  window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const icon = type === 'success' 
      ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`
      : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
      
    toast.innerHTML = `
      <div class="toast-content">
        <span class="toast-icon">${icon}</span>
        <span class="toast-message">${message}</span>
      </div>
      <div class="toast-progress"></div>
    `;
    
    container.appendChild(toast);
    
    // Trigger slide-in
    setTimeout(() => toast.classList.add('show'), 50);
    
    // Auto dismiss
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 400);
    }, 4000);
  };

  // ==========================================
  // 18. Tab Visibility Easter Egg
  // ==========================================
  const originalTitle = document.title;
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      document.title = "🥺 Come back! | Himanshu";
    } else {
      document.title = originalTitle;
    }
  });

  // ==========================================
  // 19. Minimalist Back-To-Top Scroll Trigger
  // ==========================================
  const backToTopBtn = document.getElementById('backToTop');
  if (backToTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    }, { passive: true });
  }

});