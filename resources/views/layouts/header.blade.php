{{-- navbar --}}

<style>
    /* Dropdown and transition styles */
    .dropdown-menu li {
        color: #0b226d;
    }

    .block {
        display: block;
    }

    /* Navbar transitions */
    #navbar {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    #navbar button,
    #navbar a {
        transition: color 0.3s ease;
    }

    .dropdown-menu {
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    /* Mobile menu button fixed positioning */
    #mobileMenuButton {
        position: fixed;
        top: 10px;
        right: 20px;
        z-index: 1000;
        color: white;
        background-color: #0b226d;
        padding: 10px;
        border-radius: 5px;
        display: none;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    @media (max-width: 1023px) {
        #mobileMenuButton {
            display: block;
        }
        .desktop-language-selector {
            display: none !important;
        }
    }

     @media (max-width: 1023px) {
        #mobileNavbar a,
        #mobileNavbar button {
            color: white !important;
        }

        #mobileNavbar a:hover,
        #mobileNavbar button:hover {
            color: white !important;
            background-color: transparent !important;
        }

        #coursesDropdown a {
            color: white !important;
        }
    }
    @media (max-width: 1023px) {
    #gt-mobile-43217984 img {
        height: 32px !important;
        width: 32px !important;
        border-radius: 35%;
    }
}

    /* Ensure mobile navbar is above other content */
    #mobileNavbar {
        z-index: 999;
    }

    /* Dropdown styles */
    .group:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
    }

    /* Mobile dropdown styles */
    #coursesDropdown {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    #coursesDropdown.show {
        max-height: 500px;
        /* Adjust based on your content */
    }

    /* Navbar when scrolled */
    #navbar.scrolled {
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);

    }

    #navbar.scrolled .navbar-ul button,
    #navbar.scrolled .navbar-ul a {
        color: #0b226d;
    }

    #navbar.scrolled .navbar-ul button:hover,
    #navbar.scrolled .navbar-ul a:hover {
        color: #3B82F6;
    }

    #navbar.scrolled #mobileMenuButton {
        background-color: #0b226d;
        color: white;
    }

    /* Initial state (transparent) */
    #navbar:not(.scrolled) .navbar-ul button,
    #navbar:not(.scrolled) .navbar-ul a {
        color: white;
    }

    #navbar:not(.scrolled) .navbar-ul button:hover,
    #navbar:not(.scrolled) .navbar-ul a:hover {
        color: #BFDBFE;
    }

    #navbar:not(.scrolled) #mobileMenuButton {
        background-color: rgba(30, 64, 175, 0.8);
        color: white;
    }

    /* Add this to your existing styles */
    #navbar.transparent {
        margin-top: 0.5rem;
        /* mt-2 equivalent */
    }

    #navbar.transparent.scrolled {
        margin-top: 0 !important;
    }

    /* Language selector styles */
    .language-selector-container {
        position: fixed;
        top: 10px;
        right: 80px;
        z-index: 1000;
    }
    
    @media (max-width: 640px) {
        .language-selector-container {
            right: 70px;
        }
    }
</style>

@props(['courses' => []])

<nav id="navbar" class="fixed w-full z-50 transition-all duration-300 ">
    <div class="mx-auto  px-4 sm:px-6 lg:px-8 w-full ">
        <div class="flex justify-between h-18  items-center">
            <!-- Logo and Name -->
            <div class="flex-shrink-0 flex items-center ">
                <img src="{{ asset('bakery/images/logo.png') }}" alt="Logo"
                    class="logo-img  xl:h-24 xl:w-48 h-full w-full sm:ml-10 mr-3 transition-all duration-300">
                <div id="logoName" style="font-family: 'Rubik Doodle Shadow', cursive;"></div>
            </div>

            <!-- Navbar Items -->
            <ul class="navbar-ul hidden lg:flex lg:space-x-2 xl:space-x-6 transition-all duration-300">
                <li class="relative group nav-item">
                    <a href="#">
                        <button
                            class="flex items-center justify-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            Home
                        </button>
                    </a>
                </li>
                <li class="relative group">
                    <a href="{{route('about.index')}}">
                        <button class="flex items-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            About Us
                        </button>
                    </a>
                </li>

                <!-- Courses Dropdown -->
                <li class="relative group">
                    <a href="#">
                        <button class="flex items-center font-semibold px-3 focus:outline-none transition-colors duration-300">
                            Self Assessment
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </a>
                    <ul class="dropdown-menu absolute left-0 mt-2 w-56 bg-white border border-gray-200 shadow-lg rounded-md opacity-0 invisible transition-opacity duration-300"
                        style="border-top: 4px solid #0b226d;">
                        <li class="relative group">
                            <a href="{{ route('assessment.show', ['category' => 'anxiety']) }}" class="font-medium px-4 py-2 hover:bg-blue-50 hover:underline flex items-center">
                                <div class="w-56 font-semibold text-blue-900">Anxiety</div>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="{{ route('assessment.show', ['category' => 'depression']) }}" class="font-medium px-4 py-2 hover:bg-blue-50 hover:underline flex items-center">
                                <div class="w-56 font-semibold text-blue-900">Depression</div>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="{{ route('assessment.show', ['category' => 'stress']) }}" class="font-medium px-4 py-2 hover:bg-blue-50 hover:underline flex items-center">
                                <div class="w-56 font-semibold text-blue-900">Stress</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="relative group">
                    <a href="#">
                        <button class="flex items-center font-semibold px-3 focus:outline-none transition-colors duration-300">
                            Menu
                        </button>
                    </a>
                </li> --}}

                <li class="relative group">
                    <a href="{{ route('team.index') }}">
                        <button
                            class="flex items-center font-semibold px-3 focus:outline-none transition-colors duration-300">
                            Team
                        </button>
                    </a>
                </li>

                {{-- <li class="relative group">
                    <a href="#">
                        <button
                            class="flex items-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            Alumini
                        </button>
                    </a>
                </li> --}}
                
                <li class="reltive group">
                    <a href="#">
                        <button
                            class="flex items-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            Faqs
                        </button>
                    </a>
                </li>

                <li class="relative group">
                    <a href="">
                        <button
                            class="flex items-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            Contact
                        </button>
                    </a>
                </li>
                <li class="relative group">
                    <a href="">
                        <button
                            class="flex items-center font-semibold px-3 mb-2 focus:outline-none transition-colors duration-300">
                            Gallery
                        </button>
                    </a>
                </li>

                @auth
                    <li class="relative group">
                        <a href="#">
                            <button
                                class="flex items-center text-xl font-bold px-3 py-0.5 focus:outline-none transition-colors duration-300">
                                <i class="fa-solid fa-circle-user"></i>
                            </button>
                        </a>
                    </li>
                @endauth

                <li class="relative group desktop-language-selector" style="color: black !important;">
                    <div class="language-selector text-gray-800 pl-1 py-1 rounded-md text-sm"
                        style="color: black !important;">
                        <div id="gt-desktop-43217984" style="color: black !important;"></div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="language-selector-container mobile-language-selector lg:hidden">
    <div class="language-selector text-white p-1 rounded-md text-2xl">
        <div class="" id="gt-mobile-43217984"></div>
    </div>
</div>

<button id="mobileMenuButton" class="lg:hidden">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
</button>



<!-- Mobile Navbar -->
<div id="mobileNavbar"
    class="fixed top-0 right-0 w-full sm:w-96 h-full transform translate-x-full transition-transform duration-300 z-50 lg:hidden overflow-y-auto">

    <div class="relative bg-center bg-cover h-full"
        style="background-image: url('{{ asset('bakery/images/main.jpeg') }}');">
        <div class="absolute inset-0 bg-[rgba(8,5,3,0.85)]"></div>

        <div class="relative z-10 h-full">
            <div class="flex justify-between items-center p-4 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <span>
                        <img src="{{ asset('bakery/images/logo.png') }}" alt="Logo" class="h-20 w-40 rounded-full">
                    </span>
                </div>
                <button id="closeMobileMenu" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <ul class="mt-4 space-y-2">
                <li>
                    <a href="" class="block px-4 py-2 text-lg font-semibold">Home</a>
                </li>
                <li>
                    <a href="" class="block px-4 py-2 text-lg font-semibold">About Us</a>
                </li>

                <li>
                    <button class="w-full flex justify-between items-center px-4 py-2 font-bold focus:outline-none"
                        onclick="toggleDropdown('coursesDropdown')">
                        Our Courses
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="coursesDropdown" class="hidden pl-6 space-y-1">
                        <li>
                            <a href="#" class="block px-4 py-2 text-md font-semibold">
                                Thik xa
                            </a>
                        </li>
                    </ul>
                </li>



                <li>
                    <a href="#" class="block px-4 py-2 text-lg font-semibold">Alumni</a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-2 text-lg font-semibold">FAQs</a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-2 text-lg font-semibold">Contact</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 text-lg font-semibold">Gallery</a>
                </li>
                @auth
                    <li>
                        <a href="" class="block px-4 py-2 text-lg font-semibold">Dashboard</a>
                    </li>
                @endauth
                <li>

                </li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Desktop language selector
    window.gtranslateSettings = window.gtranslateSettings || {};
    window.gtranslateSettings["desktop-43217984"] = {
        default_language: "en",
        languages: ["en", "ja", "ne", "zh-CN", "ko", "fr", "de", "es", "ar"],
        wrapper_selector: "#gt-desktop-43217984",
        native_language_names: 1,
        flag_style: "2d",
        flag_size: 24,
        horizontal_position: "inline",
    };

    // Mobile language selector
    window.gtranslateSettings["mobile-43217984"] = {
        default_language: "en",
        languages: ["en", "ja", "ne", "zh-CN", "ko", "fr", "de", "es", "ar"],
        wrapper_selector: "#gt-mobile-43217984",
        native_language_names: 1,
        flag_style: "2d",
        flag_size: 24,
        horizontal_position: "inline",
    };
</script>
<script src="{{ asset('bakery/js/gtmin.js') }}" data-gt-widget-id="desktop-43217984"></script>
<script src="{{ asset('bakery/js/gtmin.js') }}" data-gt-widget-id="mobile-43217984"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const navbar = document.getElementById("navbar");
        const logoImg = document.querySelector(".logo-img");
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileNavbar = document.getElementById("mobileNavbar");
        const closeMobileMenu = document.getElementById("closeMobileMenu");

        // Function to toggle mobile dropdown
        window.toggleDropdown = function(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('show');
        };

        // Function to check screen size and handle menu button visibility
        function handleMenuButtonVisibility() {
            if (window.innerWidth >= 1024) {
                mobileMenuButton.style.display = "none";
                mobileNavbar.classList.remove("translate-x-0");
                mobileNavbar.classList.add("translate-x-full");
                document.body.style.overflow = "";
            } else {
                if (mobileNavbar.classList.contains("translate-x-full")) {
                    mobileMenuButton.style.display = "block";
                } else {
                    mobileMenuButton.style.display = "none";
                }
            }
        }

        // Mobile menu toggle functionality
        mobileMenuButton.addEventListener("click", () => {
            mobileNavbar.classList.remove("translate-x-full");
            mobileNavbar.classList.add("translate-x-0");
            mobileMenuButton.style.display = "none";
            document.body.style.overflow = "hidden";
        });

        closeMobileMenu.addEventListener("click", () => {
            mobileNavbar.classList.remove("translate-x-0");
            mobileNavbar.classList.add("translate-x-full");
            document.body.style.overflow = "";
            handleMenuButtonVisibility();
        });

        // Close mobile menu when clicking outside
        mobileNavbar.addEventListener("click", (e) => {
            if (e.target === mobileNavbar) {
                mobileNavbar.classList.remove("translate-x-0");
                mobileNavbar.classList.add("translate-x-full");
                document.body.style.overflow = "";
                handleMenuButtonVisibility();
            }
        });

        // Handle window resize
        window.addEventListener('resize', handleMenuButtonVisibility);

        function setScrolledState() {
            navbar.classList.add("scrolled");
            navbar.classList.remove("transparent");
            logoImg.classList.add("h-16", "w-32", "ml-4");
            logoImg.classList.remove("xl:h-24", "xl:w-48", "h-full", "w-full", "ml-10");
        }

        // Function to set unscrolled state styles
        function setUnscrolledState() {
            navbar.classList.remove("scrolled");
            navbar.classList.add("transparent");
            logoImg.classList.remove("h-16", "w-32", "ml-4");
            logoImg.classList.add("xl:h-24", "xl:w-48", "h-full", "w-full", "ml-10");
        }

        // Check if we should apply scroll effects (only on homepage if needed)
        const applyScrollEffects = window.location.pathname === "/";



        if (applyScrollEffects) {
            window.addEventListener("scroll", () => {
                if (window.scrollY > 100) {
                    setScrolledState();
                } else {
                    setUnscrolledState();
                }
            });

            if (window.scrollY > 100) {
                setScrolledState();
            } else {
                setUnscrolledState();
            }
        } else {
            // On other pages, always show scrolled state
            setScrolledState();
        }

        handleMenuButtonVisibility();
    });
</script>
