<!-- About Us Section -->
<section id="about" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden">
  <div class="container mx-auto px-6">
    <!-- Section Header -->
    <div 
      class="text-center mb-16"
      data-scroll
      data-scroll-speed="0.1"
    ></a>
      <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
        <span class="opacity-0 animate-fadeIn">About Us</span>
      </h2>
      <div class="w-20 h-1 bg-blue-500 mx-auto mb-6"></div>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto opacity-0 animate-fadeIn [animation-delay:0.3s]">
        Bridging the gap between digital convenience and compassionate in-person care
      </p>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row items-center gap-12">
      <!-- Left Column - Image -->
      <div 
        class="w-full lg:w-1/2 relative opacity-0 animate-slideInLeft"
        data-scroll
        data-scroll-speed="0.2"
      >
        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
          <img 
            src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
            alt="Calm Core Recovery Team" 
            class="w-full h-[700px] object-cover transition-transform duration-1000 hover:scale-105"
          >
          <div class="absolute inset-0 bg-blue-900 opacity-20"></div>
        </div>
        
        <!-- Floating stats cards -->
        <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-xl shadow-lg opacity-0 animate-fadeIn [animation-delay:0.8s]">
          <h4 class="text-3xl font-bold text-blue-600">10+</h4>
          <p class="text-gray-600">Years Experience</p>
        </div>
        
        <div class="absolute -top-8 -right-8 bg-white p-6 rounded-xl shadow-lg opacity-0 animate-fadeIn [animation-delay:1s]">
          <h4 class="text-3xl font-bold text-blue-600">5K+</h4>
          <p class="text-gray-600">Lives Transformed</p>
        </div>
      </div>

      <!-- Right Column - Text Content -->
      <div 
        class="w-full lg:w-1/2 opacity-0 animate-slideInRight"
        data-scroll
        data-scroll-speed="0.1"
      >
        <h3 class="text-3xl font-bold text-gray-800 mb-6">
          <span class="opacity-0 animate-fadeIn [animation-delay:0.5s]">Compassionate Care, Wherever You Are</span>
        </h3>
        
        <p class="text-lg text-gray-600 mb-6 opacity-0 animate-fadeIn [animation-delay:0.7s]">
         Calm Core Recovery is a pioneering mental health and rehabilitation platform dedicated to transforming care in Nepal through innovative digital solutions. Founded in 2023 by a team of mental health professionals and technology experts, we bridge the gap between traditional therapy and modern accessibility by offering both online and offline services. Our mission is to make compassionate, evidence-based mental health support available to everyone—regardless of location, income, or circumstance.
        </p>
         <p class="text-lg text-gray-600 mb-6 opacity-0 animate-fadeIn [animation-delay:0.7s]">
        We address critical gaps in Nepal’s mental healthcare system, including fragmented patient records, limited provider-patient communication, and lack of continuity in therapy. Our hybrid platform combines secure digital tools (AI chatbots, progress tracking, emergency panic buttons) with in-person care, ensuring support reaches even remote areas with limited internet access. With over 5,000 lives impacted and an 85% success rate, we prioritize personalized, stigma-free care tailored to individual needs.
        </p>
                 <p class="text-lg text-gray-600 mb-6 opacity-0 animate-fadeIn [animation-delay:0.7s]">
            What sets us apart is our commitment to accessibility, innovation, and community. From teletherapy sessions to multilingual resources in Nepali and English, we empower users to take control of their mental wellness journey.
        </p>
        
        
        <div class="mt-10 opacity-0 animate-fadeIn [animation-delay:1.5s]">
          <a href="#contact" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            Start Your Journey
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- <!-- Animated Divider -->
<div class="relative h-24 overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 opacity-20"></div>
  <div class="absolute inset-0 flex items-center justify-center">
    <div class="h-1 w-64 bg-blue-500 rounded-full animate-pulse"></div>
  </div>
</div> --}}

<!-- Tailwind Config for Animations -->
<style>
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  @keyframes slideInLeft {
    from { 
      opacity: 0;
      transform: translateX(-50px);
    }
    to { 
      opacity: 1;
      transform: translateX(0);
    }
  }
  @keyframes slideInRight {
    from { 
      opacity: 0;
      transform: translateX(50px);
    }
    to { 
      opacity: 1;
      transform: translateX(0);
    }
  }
  .animate-fadeIn {
    animation: fadeIn 3s ease forwards;
  }
  .animate-slideInLeft {
    animation: slideInLeft 3s ease forwards;
  }
  .animate-slideInRight {
    animation: slideInRight 3s ease forwards;
  }
</style>

<!-- ScrollReveal Script (add this to your existing scripts) -->
<script src="https://unpkg.com/scrollreveal"></script>
<script>
  ScrollReveal().reveal('[data-scroll]', {
    delay: 300,
    distance: '50px',
    duration: 1000,
    easing: 'ease',
    interval: 100,
    origin: 'bottom',
    reset: false
  });
</script>


