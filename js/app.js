// Smooth fade-in for toy cards
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".toy-card");
    cards.forEach((card, index) => {
      card.style.opacity = 0;
      card.style.transition = "opacity 0.5s ease " + (index * 0.1) + "s";
      setTimeout(() => {
        card.style.opacity = 1;
      }, 100);
    });
  });
  
  // Search bar filter (if you have a search input with id="toySearch")
  const toySearch = document.getElementById("toySearch");
  if (toySearch) {
    toySearch.addEventListener("keyup", () => {
      const searchValue = toySearch.value.toLowerCase();
      const toyCards = document.querySelectorAll(".toy-card");
  
      toyCards.forEach(card => {
        const name = card.querySelector("h3").innerText.toLowerCase();
        card.style.display = name.includes(searchValue) ? "block" : "none";
      });
    });
  }
  
  // Mood-based filter buttons (e.g. data-mood="Educational")
  const moodButtons = document.querySelectorAll(".mood-filter");
  moodButtons.forEach(button => {
    button.addEventListener("click", () => {
      const mood = button.dataset.mood;
      const toyCards = document.querySelectorAll(".toy-card");
  
      toyCards.forEach(card => {
        const category = card.dataset.category;
        card.style.display = (mood === "all" || category === mood) ? "block" : "none";
      });
    });
  });
  
  // Toggle wishlist heart (class="wishlist-icon")
  document.querySelectorAll(".wishlist-icon").forEach(icon => {
    icon.addEventListener("click", () => {
      icon.classList.toggle("active");
      alert("💖 Wishlist updated!");
    });
  });
  
  // Optional click sounds (attach .click-sound to buttons/links)
  const clickSound = new Audio("sounds/click.mp3"); // add your own sound file in sounds/
  document.querySelectorAll(".click-sound").forEach(el => {
    el.addEventListener("click", () => {
      clickSound.play();
    });
  });
  
  // Toast alert function (optional)
  function showToast(message) {
    const toast = document.createElement("div");
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.bottom = "30px";
    toast.style.left = "50%";
    toast.style.transform = "translateX(-50%)";
    toast.style.background = "#4caf50";
    toast.style.color = "white";
    toast.style.padding = "10px 20px";
    toast.style.borderRadius = "8px";
    toast.style.boxShadow = "0 2px 10px rgba(0,0,0,0.2)";
    toast.style.zIndex = 9999;
    toast.style.fontFamily = "Comic Sans MS, cursive";
  
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.remove();
    }, 3000);
  }
  
  // Mobile menu toggle (if used)
  const mobileMenuBtn = document.getElementById("mobile-menu-btn");
  const mobileMenu = document.getElementById("mobile-nav");
  
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("visible");
    });
  }
  
  // Main Application JavaScript

  // DOM Elements
  const gameModal = document.getElementById('gameModal');
  const gameContainer = document.getElementById('gameContainer');
  const closeModal = document.querySelector('.close-modal');
  const newsletterForm = document.getElementById('newsletterForm');

  // Carousel functionality
  let currentSlide = 0;
  const slides = document.querySelectorAll('.carousel-item');
  const totalSlides = slides.length;

  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    slides[index].classList.add('active');
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
  }

  // Initialize carousel
  if (slides.length > 0) {
    setInterval(nextSlide, 5000);
  }

  // Game Modal Functionality
  const modal = document.getElementById('gameModal');
  const closeModal = document.querySelector('.close-modal');
  const gameContainer = document.getElementById('gameContainer');

  // Close modal when clicking the X or outside the modal
  closeModal.onclick = function() {
    modal.style.display = "none";
    gameContainer.innerHTML = ''; // Clear game content
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
      gameContainer.innerHTML = ''; // Clear game content
    }
  }

  // Function to start a game
  function startGame(gameType) {
    modal.style.display = "block";
    gameContainer.innerHTML = ''; // Clear previous game content

    // Add game-specific content
    switch(gameType) {
      case 'memory':
        initializeMemoryGame();
        break;
      case 'puzzle':
        initializePuzzleGame();
        break;
      case 'counting':
        initializeCountingGame();
        break;
    }
  }

  // Prevent scrolling when modal is open
  modal.addEventListener('show', function() {
    document.body.style.overflow = 'hidden';
  });

  modal.addEventListener('hide', function() {
    document.body.style.overflow = 'auto';
  });

  // Newsletter form handling
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const email = newsletterForm.querySelector('input[type="email"]').value;
      
      try {
        const response = await fetch('subscribe.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ email }),
        });

        if (response.ok) {
          alert('Thank you for subscribing!');
          newsletterForm.reset();
        } else {
          throw new Error('Subscription failed');
        }
      } catch (error) {
        alert('Sorry, there was an error. Please try again later.');
      }
    });
  }

  // Quick view functionality
  document.querySelectorAll('.quick-view').forEach(button => {
    button.addEventListener('click', (e) => {
      e.stopPropagation();
      const toyCard = button.closest('.toy-card');
      const toyName = toyCard.querySelector('h3').textContent;
      const toyPrice = toyCard.querySelector('.price').textContent;
      
      // Show quick view modal with toy details
      alert(`Quick View: ${toyName}\nPrice: ${toyPrice}`);
    });
  });

  // Rating system
  document.querySelectorAll('.rating i').forEach(star => {
    star.addEventListener('click', function() {
      const rating = this.dataset.rating;
      const toyCard = this.closest('.toy-card');
      const toyName = toyCard.querySelector('h3').textContent;
      
      // Send rating to server
      fetch('rate.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          toy: toyName,
          rating: rating
        }),
      });
    });
  });

  // Smooth scrolling for navigation
  document.querySelectorAll('nav a').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href');
      if (targetId.startsWith('#')) {
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth'
          });
        }
      } else {
        window.location.href = targetId;
      }
    });
  });

  // Hero Carousel
  document.addEventListener('DOMContentLoaded', function() {
    const carouselItems = document.querySelectorAll('.carousel-item');
    let currentIndex = 0;

    function showSlide(index) {
      carouselItems.forEach(item => item.classList.remove('active'));
      carouselItems[index].classList.add('active');
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % carouselItems.length;
      showSlide(currentIndex);
    }

    // Show first slide immediately
    showSlide(currentIndex);

    // Auto-advance slides every 5 seconds
    setInterval(nextSlide, 5000);
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });

  // Add animation on scroll
  const animateOnScroll = () => {
    const elements = document.querySelectorAll('.hero-content, .feature-card, .toy-card');
    
    elements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const screenPosition = window.innerHeight / 1.3;
      
      if(elementPosition < screenPosition) {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
      }
    });
  };

  window.addEventListener('scroll', animateOnScroll);
  window.addEventListener('load', animateOnScroll);

  // Image loading handler
  document.addEventListener('DOMContentLoaded', function() {
    const toyImages = document.querySelectorAll('.toy-image img');
    
    toyImages.forEach(img => {
      // Add loading class
      img.parentElement.classList.add('loading');
      
      // Handle successful load
      img.addEventListener('load', function() {
        this.parentElement.classList.remove('loading');
      });
      
      // Handle error
      img.addEventListener('error', function() {
        this.parentElement.classList.remove('loading');
        this.style.display = 'none';
        this.parentElement.style.backgroundColor = '#f5f5f5';
        
        // Add error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'image-error';
        errorMsg.innerHTML = '<i class="fas fa-image"></i><br>Image not available';
        this.parentElement.appendChild(errorMsg);
      });
    });
  });
  