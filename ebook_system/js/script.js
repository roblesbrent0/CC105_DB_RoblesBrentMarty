document.getElementById('toggle-icon').addEventListener('click', function(event) {
    const navLinks = document.getElementById('nav-links');
    const currentRight = getComputedStyle(navLinks).right;
    
    if (currentRight === '0px') {
        navLinks.style.right = '-300px'; // Slide out
    } else {
        navLinks.style.right = '0'; // Slide in
    }

    event.stopPropagation(); // Prevent click from propagating to document
});

// Close the nav menu if the user clicks outside
document.addEventListener('click', function(event) {
    const navLinks = document.getElementById('nav-links');
    const toggleIcon = document.getElementById('toggle-icon');
    
    // Check if the click is outside the nav menu and the toggle icon
    if (!navLinks.contains(event.target) && event.target !== toggleIcon) {
        navLinks.style.right = '-300px'; // Slide out
    }
});