<!-- Load Cursive Font -->
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

<style>
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

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
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

  .animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
  }

  .handwriting {
    font-family: 'Great Vibes', cursive;
    white-space: nowrap;
    overflow: hidden;
    display: inline-block;
    animation: handwriting 3s steps(60, end) forwards;
    font-weight: heavy;
  }

  @media (min-width: 768px) {
    .hero-h1 {
      margin-top: 4rem;
    }
  }
</style>

<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
  <!-- Background Video -->
  <div class="absolute inset-0 z-0">
    <video
      id="hero-video"
      class="w-full h-full object-cover"
      autoplay
      muted
      loop
      playsinline
    >
      <source src="https://cdn.midjourney.com/video/cd0cd56e-6c5c-440d-b481-3a43c4aea471/2.mp4" type="video/mp4" />
    </video>

    <!-- Overlay -->
    <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.4); z-index: 1;"></div>
  </div>

  <!-- Content -->
  <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
    <!-- Heading -->
    <h1
      class="text-6xl md:text-6xl lg:text-9xl mb-8 leading-tight handwriting hero-h1"
      style="color: #bfdaeb;"
    >
      Calm Core Recovery
    </h1>

    <!-- Floating Elements -->
    <div class="absolute top-1/4 left-10 w-4 h-4 rounded-full animate-float" style="background-color: #1E90FF33;"></div>
    <div class="absolute top-1/3 right-20 w-6 h-6 rounded-full animate-float-delayed" style="background-color: #00BFFF33;"></div>
    <div class="absolute top-4/5 right-5 w-6 h-6 rounded-full animate-float-delayed" style="background-color: #00BFFF33;"></div>
    <div class="absolute bottom-1/4 left-1/4 w-3 h-3 rounded-full animate-float" style="background-color: #87CEFA40; animation-delay: 1s;"></div>
  </div>

  <!-- Bottom Button instead of scroll indicator -->
  <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
    <button
      class="group relative px-8 py-4 rounded-full text-lg font-semibold transition-all duration-500 hover:scale-110"
      style="background: linear-gradient(to right, #000f1e, #034586); color: #F8F8FF;"
    >
      Begin Your Journey
    </button>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const heroVideo = document.getElementById("hero-video");
    if (heroVideo) {
      heroVideo.play().catch((error) => {
        console.log("Autoplay was prevented:", error);
      });
    }
  });
</script>
