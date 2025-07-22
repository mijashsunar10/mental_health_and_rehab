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

  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(40px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
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

  .animate-fadeInUp {
    animation: fadeInUp 1.2s ease-out forwards;
  }

  .delay-1 {
    animation-delay: 0.2s;
  }

  .delay-2 {
    animation-delay: 0.4s;
  }

  .delay-3 {
    animation-delay: 0.6s;
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
      class="text-4xl md:text-6xl lg:text-8xl font-bold mb-8 leading-tight animate-fadeInUp delay-1"
      style="color: #F8F8FF;"
    >
      Where Technology Meets Healing
    </h1>

    <!-- Subtitle -->
    <p
      class="text-xl md:text-2xl lg:text-3xl mb-12 max-w-4xl mx-auto leading-relaxed animate-fadeInUp delay-2"
      style="color: #F8F8FFB3;"
    >
      Experience the future of mental wellness through immersive,
      AI-powered recovery programs designed to restore your inner calm
    </p>

    <!-- Buttons -->
    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fadeInUp delay-3">
      <!-- Primary CTA -->
      <button
        class="group relative px-8 py-4 rounded-full text-lg font-semibold transition-all duration-500 hover:scale-110"
        style="background: linear-gradient(to right, #1E90FF, #00BFFF); color: #F8F8FF;"
      >
        Begin Your Journey
      </button>

      <!-- Secondary CTA -->
      <button
        class="group px-8 py-4 rounded-full text-lg font-semibold transition-all duration-500 hover:scale-105 border"
        style="background-color: rgba(255, 255, 255, 0.05); color: #F8F8FF; border-color: #ffffff40;"
      >
        <span class="flex items-center gap-2">
          <svg
            class="w-5 h-5 group-hover:animate-pulse"
            fill="#F8F8FF"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
              clip-rule="evenodd"
            />
          </svg>
          Watch Demo
        </span>
      </button>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-1/4 left-10 w-4 h-4 rounded-full animate-float" style="background-color: #1E90FF33;"></div>
    <div class="absolute top-1/3 right-20 w-6 h-6 rounded-full animate-float-delayed" style="background-color: #00BFFF33;"></div>
    <div class="absolute bottom-1/4 left-1/4 w-3 h-3 rounded-full animate-float" style="background-color: #87CEFA40; animation-delay: 1s;"></div>
  </div>

  <!-- Scroll Indicator -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
    <div
      class="w-6 h-10 border-2 rounded-full flex justify-center"
      style="border-color: #F8F8FF80;"
    >
      <div class="w-1 h-3 mt-2 animate-pulse" style="background-color: #00BFFF;"></div>
    </div>
  </div>
</div>
<div style="height: 100vh"> 
  <p class="primary">k xa</p>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const heroVideo = document.getElementById("hero-video");
    if (heroVideo) {
      heroVideo.play().catch((error) => {
        console.log("Autoplay was prevented:", error);
      });
    }

    const scrollIndicator = document.querySelector(".scroll-indicator");
    if (scrollIndicator) {
      scrollIndicator.addEventListener("click", () => {
        window.scrollBy({
          top: window.innerHeight,
          behavior: "smooth",
        });
      });
    }
  });
</script>
