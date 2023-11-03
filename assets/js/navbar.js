class MobileNavbar {
    constructor(mobileMenu, navList, navLinks) {
        this.mobileMenu = document.querySelector(mobileMenu); // Select the mobile menu element
        this.navList = document.querySelector(navList); // Select the navigation list element
        this.navLinks = document.querySelectorAll(navLinks); // Select all navigation links
        this.activeClass = 'active'; // Define the CSS class for the active state

        this.handleClick = this.handleClick.bind(this); // Bind the handleClick method to this instance
    }

    animateLinks() {
        this.navLinks.forEach((link, index) => {
            link.style.animation
                ? (link.style.animation = "")
                : (link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`);
        });
    }

    handleClick() {
        this.navList.classList.toggle(this.activeClass); // Toggle the active class on the navigation list
        this.mobileMenu.classList.toggle(this.activeClass); // Toggle the active class on the mobile menu
        this.animateLinks(); // Call the animateLinks method to animate the links
    }

    addClickEvent() {
        this.mobileMenu.addEventListener('click', this.handleClick); // Add a click event listener to the mobile menu
    }

    init() {
        if (this.mobileMenu) {
            this.addClickEvent(); // Initialize the mobile navigation if the mobile menu element exists
        }
        return this; // Return the instance of the MobileNavbar
    }
}

const mobileNavbar = new MobileNavbar(
    ".mobile-menu", // Selector for the mobile menu
    ".nav-links", // Selector for the navigation list
    ".nav-link" // Selector for the navigation links
);

mobileNavbar.init(); // Initialize the mobile navigation
