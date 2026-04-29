document.addEventListener('DOMContentLoaded', () => {

  // --- Hero Slider Logic ---
  const slides = document.querySelectorAll('.hero-slide');
  const nextBtn = document.querySelector('.slider-btn.next');
  const prevBtn = document.querySelector('.slider-btn.prev');

  if (slides.length > 0 && nextBtn && prevBtn) {
    let currentSlide = 0;

    function showSlide(index) {
      slides.forEach(slide => slide.classList.remove('active'));
      slides[index].classList.add('active');
    }

    nextBtn.addEventListener('click', () => {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    });

    prevBtn.addEventListener('click', () => {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      showSlide(currentSlide);
    });

    setInterval(() => {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }, 8000);
  }

  // --- Scroll Animations (Intersection Observer) ---
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, observerOptions);

  document.querySelectorAll('.card, .hero-content, .section-title, .cta, .animate').forEach(el => {
    el.classList.add('reveal');
    observer.observe(el);
  });

  // --- Mobile Menu Toggle ---
  const mobileToggle = document.querySelector('.mobile-nav-toggle');
  const navLinks = document.querySelector('.nav-links');

  if (mobileToggle && navLinks) {
    mobileToggle.addEventListener('click', () => {
      navLinks.classList.toggle('nav-active');
      mobileToggle.classList.toggle('toggle-active');
      document.body.classList.toggle('no-scroll');
    });

    // Close menu when link is clicked
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('nav-active');
        mobileToggle.classList.remove('toggle-active');
        document.body.classList.remove('no-scroll');
      });
    });
  }

  // --- Theme Toggle ---
  const themeToggle = document.querySelector('.theme-toggle');
  const body = document.body;
  const icon = themeToggle ? themeToggle.querySelector('i') : null;

  // Check saved preference
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) {
      body.setAttribute('data-theme', savedTheme);
      updateIcon(savedTheme);
  }

  if (themeToggle) {
      themeToggle.addEventListener('click', () => {
          const currentTheme = body.getAttribute('data-theme');
          const newTheme = currentTheme === 'light' ? 'dark' : 'light';
          
          body.setAttribute('data-theme', newTheme);
          localStorage.setItem('theme', newTheme);
          updateIcon(newTheme);
      });
  }

  function updateIcon(theme) {
      if (!icon) return;
      if (theme === 'light') {
          icon.classList.remove('fa-sun');
          icon.classList.add('fa-moon');
      } else {
          icon.classList.remove('fa-moon');
          icon.classList.add('fa-sun');
      }
  }
});