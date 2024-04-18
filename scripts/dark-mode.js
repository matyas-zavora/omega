// Function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('theme', themeName); // Store the selected theme in local storage
    document.documentElement.className = themeName; // Set the class of the root element to apply the theme
    if (themeName === 'theme-dark') {
        document.getElementById('switch').innerHTML = '<i class="bi bi-moon"></i>'; // Update the switch button icon for dark mode
        setDark(); // Apply dark mode styles
    } else if (themeName === 'theme-light') {
        document.getElementById('switch').innerHTML = '<i class="bi bi-brightness-high"></i>'; // Update the switch button icon for light mode
        setLight(); // Apply light mode styles
    } else if (themeName === 'theme-device') {
        // Determine the appropriate icon based on device screen size
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        let deviceIcon = '<i class="bi ';
        if (window.innerWidth < 600) {
            deviceIcon += 'bi-phone"></i>'; // Use phone icon for small screens (e.g., phones)
        } else if (window.innerWidth < 1024) {
            deviceIcon += 'bi-tablet"></i>'; // Use tablet icon for medium screens (e.g., tablets)
        } else {
            deviceIcon += 'bi-laptop"></i>'; // Use laptop icon for large screens (e.g., PCs, laptops)
        }
        document.getElementById('switch').innerHTML = deviceIcon; // Update the switch button icon
        // Apply dark or light mode based on device preference
        if (prefersDarkMode) {
            setDark();
        } else {
            setLight();
        }
    }
}

// Function to apply light mode styles
function setLight(){
    document.documentElement.setAttribute('data-bs-theme', 'light'); // Set Bootstrap theme to light
    document.body.classList.remove('bg-dark'); // Remove dark mode background color class from body
    document.body.classList.add('bg-light'); // Add light mode background color class to body
    if (document.getElementById('navbar') !== null) {
        document.getElementById('navbar').classList.remove('bg-dark'); // Remove dark mode background color class from navbar
        document.getElementById('navbar').classList.add('bg-light'); // Add light mode background color class to navbar
    }
}

// Function to apply dark mode styles
function setDark(){
    document.documentElement.setAttribute('data-bs-theme', 'dark'); // Set Bootstrap theme to dark
    document.body.classList.remove('bg-light'); // Remove light mode background color class from body
    document.body.classList.add('bg-dark'); // Add dark mode background color class to body
    if (document.getElementById('navbar') !== null) {
        document.getElementById('navbar').classList.remove('bg-light'); // Remove light mode background color class from navbar
        document.getElementById('navbar').classList.add('bg-dark'); // Add dark mode background color class to navbar
    }
}

// Array containing available themes
const themes = ['theme-dark', 'theme-light', 'theme-device'];

// Function to cycle through themes: dark mode, light mode, and device's preference
function cycleThemes() {
    const currentTheme = localStorage.getItem('theme'); // Get the current theme from local storage
    let nextThemeIndex = (themes.indexOf(currentTheme) + 1) % themes.length; // Calculate the index of the next theme
    let nextTheme = themes[nextThemeIndex]; // Get the next theme from the array
    setTheme(nextTheme); // Apply the next theme
}

// Immediately invoked function to set the theme on initial load
(function () {
    const savedTheme = localStorage.getItem('theme'); // Get the saved theme from local storage
    if (savedTheme) {
        setTheme(savedTheme); // Apply the saved theme if available
    } else {
        // Set the theme based on device preference if no saved theme is available
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDarkMode) {
            setTheme('theme-dark'); // Apply dark mode if preferred by the device
        } else {
            setTheme('theme-light'); // Apply light mode if preferred by the device
        }
    }
})();
