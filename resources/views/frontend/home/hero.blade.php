<!-- Load Cursive Font -->
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

<style>
  /* Base Styles */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  /* Animations */
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
  }

  @keyframes bounce {
    0%, 100% {
      transform: translateY(-25%);
      animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
      transform: translateY(0);
      animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
  }

  @keyframes handwriting {
    0% {
      width: 0;
      opacity: 0;
    }
    100% {
      width: 100%;
      opacity: 1;
    }
  }

  .animate-float {
    animation: float 6s ease-in-out infinite;
  }

  .animate-float-delayed {
    animation: float 6s ease-in-out infinite 2s;
  }

  .animate-bounce {
    animation: bounce 2s infinite;
  }

  .handwriting {
    font-family: 'Great Vibes', cursive;
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
    animation: handwriting 3s steps(60, end) forwards;
    color: #bfdaeb;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    width: 100%;
    text-align: center;
  }

  /* Layout Styles */
  .hero-container {
    position: relative;
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .video-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
  }

  .video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
  }

  .content-wrapper {
    position: relative;
    z-index: 10;
    text-align: center;
    width: 100%;
    max-width: 1200px;
    padding: 0 1rem;
    margin: 0 auto;
  }

  /* Button Styles */
  .hero-button {
    position: relative;
    display: inline-block;
    padding: 0.8rem 1.8rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 50px;
    background: linear-gradient(to right, #ebeef0, #898a8a);
    color: #000000;
    border: none;
    cursor: pointer;
    overflow: hidden;
    opacity: 0.7;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(10, 147, 201, 0.2);
    z-index: 1;
  }

  .hero-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, #034586, #000f1e);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
  }

  .hero-button:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
  }

  .hero-button:hover::before {
    opacity: 1;
  }

  /* Floating Elements */
  .floating-element {
    position: absolute;
    border-radius: 50%;
    z-index: 5;
    pointer-events: none;
  }

  /* Responsive Adjustments */
  /* Mobile (default) */
  .hero-heading {
    font-size: 2.8rem;
    line-height: 1.2;
    margin: 1.5rem 0;
  }

  .button-container {
    position: absolute;
    left: 50%;
    bottom: 1rem;
    transform: translateX(-50%);
  }

  /* Small tablets and large phones (600px and up) */
  @media (min-width: 600px) {
    .hero-heading {
      font-size: 3.5rem;
      margin: 2rem 0;
    }
    
    .hero-button {
      padding: 1rem 2rem;
      font-size: 1.1rem;
    }
  }

  /* Tablets and small desktops (768px and up) */
  @media (min-width: 768px) {
    .hero-heading {
      font-size: 4.5rem;
      margin: 2.5rem 0;
    }
    
    .floating-element {
      display: block;
    }
    
    .button-container {
      bottom: 2rem;
    }
  }

  /* Large tablets and small desktops (1024px and up) */
  @media (min-width: 1024px) {
    .hero-heading {
      font-size: 6rem;
      margin: 3rem 0;
    }
    
    .hero-button {
      padding: 1.2rem 2.5rem;
      font-size: 1.2rem;
    }
  }

  /* Large desktops (1200px and up) */
  @media (min-width: 1200px) {
    .hero-heading {
      font-size: 7rem;
    }
  }

  /* Extra large desktops (1600px and up) */
  @media (min-width: 1600px) {
    .hero-heading {
      font-size: 9rem;
    }
    
    .hero-button {
      padding: 1.5rem 3rem;
      font-size: 1.3rem;
    }
  }
</style>

<div class="hero-container">
  <!-- Background Video -->
  <video class="video-background" id="hero-video" autoplay muted loop playsinline>
    <source src="{{asset('videos/background1.mp4')}}" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  
  <div class="video-overlay"></div>

  <!-- Content -->
  <div class="content-wrapper">
    <!-- Heading -->
    <h1 class="hero-heading handwriting">
      Calm Core Recovery
    </h1>

    <!-- Floating Elements -->
    <div class="floating-element top-1/4 left-10 w-4 h-4 animate-float" style="background-color: #1E90FF33;"></div>
    <div class="floating-element top-1/3 right-20 w-6 h-6 animate-float-delayed" style="background-color: #00BFFF33;"></div>
    <div class="floating-element top-4/5 right-5 w-6 h-6 animate-float-delayed" style="background-color: #00BFFF33;"></div>
    <div class="floating-element bottom-1/4 left-1/4 w-3 h-3 animate-float" style="background-color: #87CEFA40; animation-delay: 1s;"></div>
  </div>

  <!-- Button -->
  <div class="button-container ">
    <button class="hero-button">
      Begin Your Journey
    </button>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Video handling
    const heroVideo = document.getElementById('hero-video');
    const handleVideo = () => {
      if (heroVideo) {
        const playPromise = heroVideo.play();
        if (playPromise !== undefined) {
          playPromise.catch(error => {
            console.log("Autoplay was prevented:", error);
            // Fallback: Show poster image or play button
          });
        }
      }
    };
    
    // Mobile viewport height adjustment
    const setViewportHeight = () => {
      const vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
      document.querySelector('.hero-container').style.minHeight = 'calc(var(--vh, 1vh) * 100)';
    };
    
    // Initial setup
    handleVideo();
    setViewportHeight();
    
    // Event listeners
    window.addEventListener('resize', setViewportHeight);
    window.addEventListener('orientationchange', () => {
      setTimeout(setViewportHeight, 150);
    });
    
    // Modern approach to handle mobile browsers' address bar
    let lastWindowHeight = window.innerHeight;
    const handleResize = () => {
      if (Math.abs(lastWindowHeight - window.innerHeight) > 150) {
        setViewportHeight();
        lastWindowHeight = window.innerHeight;
      }
    };
    window.addEventListener('resize', handleResize);
  });
</script>