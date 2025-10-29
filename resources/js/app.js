import '../css/app.css';


// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById("mobileMenuBtn");
const mobileMenu = document.getElementById("mobileMenu");
mobileMenuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
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

if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/service-worker.js")
        .then(() => console.log("Service Worker registered."));
}
