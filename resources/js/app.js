// Initialize Swiper
const swiper = new Swiper(".servicesSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});

// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById("mobileMenuBtn");
const mobileMenu = document.getElementById("mobileMenu");
mobileMenuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
});

// Login/Register functionality
const loginBtn = document.getElementById("loginBtn");
const registerBtn = document.getElementById("registerBtn");
const userAvatar = document.getElementById("userAvatar");

loginBtn.addEventListener("click", () => {
    // Simulate login
    loginBtn.classList.add("hidden");
    registerBtn.classList.add("hidden");
    userAvatar.classList.remove("hidden");
});

userAvatar.addEventListener("click", () => {
    // Simulate logout
    if (confirm("Logout?")) {
        userAvatar.classList.add("hidden");
        loginBtn.classList.remove("hidden");
        registerBtn.classList.remove("hidden");
    }
});

// File upload display
const fileInput = document.getElementById("paymentProof");
const fileName = document.getElementById("fileName");
fileInput.addEventListener("change", (e) => {
    if (e.target.files.length > 0) {
        fileName.textContent = e.target.files[0].name;
    }
});

// Scroll to top button
const scrollTopBtn = document.getElementById("scrollTop");
window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.style.opacity = "1";
        scrollTopBtn.style.pointerEvents = "auto";
    } else {
        scrollTopBtn.style.opacity = "0";
        scrollTopBtn.style.pointerEvents = "none";
    }
});

scrollTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({ behavior: "smooth", block: "start" });
            // Close mobile menu if open
            mobileMenu.classList.add("hidden");
        }
    });
});

// Form submission
document.querySelector("#booking form").addEventListener("submit", (e) => {
    e.preventDefault();
    alert("Booking submitted! We will contact you shortly for confirmation.");
});

document.querySelector("#contact form").addEventListener("submit", (e) => {
    e.preventDefault();
    alert("Message sent! We will get back to you soon.");
});
