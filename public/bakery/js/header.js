document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.getElementById("navbar");
  const logoImg = document.querySelector(".logo-img");
  const navUl = document.querySelector(".navbar-ul");

  // 1. First, explicitly set initial transparent background
  navbar.classList.add("bg-transparent");

  // Function to get clean path from URL or route
  function getCleanPath(url) {
    const a = document.createElement('a');
    a.href = url;
    return a.pathname.split('?')[0].split('#')[0];
  }

  // Function to highlight active nav item
  function highlightActiveNavItem() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar-ul a[href]');
    
    navLinks.forEach(link => {
      const href = link.getAttribute('href');
      const linkPath = getCleanPath(href);
      
      if (currentPath === linkPath) {
        const button = link.querySelector('button');
        if (button) {
          button.classList.add('text-[#5E2C04]'); // Darker brown for active items
          button.classList.remove('text-[#FFF8E1]', 'text-[#8B4513]', 'hover:text-[#D4A76A]');
          button.dataset.active = "true";
        }
      } else {
        const button = link.querySelector('button');
        if (button) {
          button.classList.remove('text-[#5E2C04]');
          if (navbar.classList.contains('scrolled')) {
            button.classList.add('text-[#8B4513]'); // Regular brown for non-active items
          } else {
            button.classList.add('text-[#FFF8E1]'); // Light color when transparent
          }
          button.classList.add('hover:text-[#D4A76A]');
          button.removeAttribute('data-active');
        }
      }
    });
  }

  // Function to set scrolled state styles
  function setScrolledState() {
    navbar.classList.add("scrolled", "shadow-lg", "bg-[#FFF8E1]"); // Light background
    navbar.classList.remove("bg-transparent");
    logoImg.classList.add("h-16", "w-32", "ml-4");
    logoImg.classList.remove("xl:h-24", "xl:w-48", "h-full", "w-full", "ml-10");
    navUl.classList.add("mt-2");
    navbar.querySelectorAll("button, a").forEach((el) => {
      if (!el.hasAttribute('data-active')) {
        el.classList.add("text-[#8B4513]"); // Brown text on light background
        el.classList.remove("text-[#FFF8E1]");
      }
    });
  }

  // Function to set unscrolled state styles (homepage only)
  function setUnscrolledState() {
    navbar.classList.remove("scrolled", "shadow-lg", "bg-[#FFF8E1]");
    navbar.classList.add("bg-transparent");
    logoImg.classList.remove("h-16", "w-32", "ml-4");
    logoImg.classList.add("xl:h-24", "xl:w-48", "h-full", "w-full", "ml-10");
    navUl.classList.remove("mt-2");
    navbar.querySelectorAll("button, a").forEach((el) => {
      if (!el.hasAttribute('data-active')) {
        el.classList.add("text-[#FFF8E1]"); // Light text when transparent
        el.classList.remove("text-[#8B4513]");
      }
    });
  }

  // Check if homepage
  if (window.location.pathname === "/") {
    // Homepage behavior
    window.addEventListener("scroll", () => {
      if (window.scrollY > 100) { // Increased threshold to 100px
        setScrolledState();
      } else {
        setUnscrolledState();
      }
    });

    // Set initial state
    if (window.scrollY > 100) {
      setScrolledState();
    } else {
      setUnscrolledState();
    }
  } else {
    // All other pages - always use scrolled state
    setScrolledState();
  }

  // Highlight active nav item (for all pages)
  highlightActiveNavItem();
});