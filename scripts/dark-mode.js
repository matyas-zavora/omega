// Function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    document.documentElement.className = themeName;
    if (themeName === 'theme-dark') {
        document.getElementById('switch').innerHTML = '<i class="bi bi-moon"></i>';
        setDark();
    } else if (themeName === 'theme-light') {
        document.getElementById('switch').innerHTML = '<i class="bi bi-brightness-high"></i>';
        document.documentElement.setAttribute('data-bs-theme', 'light');
        document.body.classList.remove('bg-dark');
        document.body.classList.add('bg-light');
        document.getElementById('jecna-logo').classList.remove('inverted-logo');
        document.getElementById('mojerande-logo').src = './img/light.png';
        document.getElementById('navbar').classList.remove('bg-dark');
        document.getElementById('navbar').classList.add('bg-light');
    } else if (themeName === 'theme-device') {
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        let deviceIcon = '<i class="bi ';

        if (window.innerWidth < 600) {
            deviceIcon += 'bi-phone"></i>'; // Use phone icon for small screens (e.g., phones)
        } else if (window.innerWidth < 1024) {
            deviceIcon += 'bi-tablet"></i>'; // Use tablet icon for medium screens (e.g., tablets)
        } else {
            deviceIcon += 'bi-laptop"></i>'; // Use laptop icon for large screens (e.g., PCs, laptops)
        }

        document.getElementById('switch').innerHTML = deviceIcon;

        if (prefersDarkMode) {
            setDark();
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'light');
            document.body.classList.remove('bg-dark');
            document.body.classList.add('bg-light');
            document.getElementById('jecna-logo').classList.remove('inverted-logo');
            document.getElementById('mojerande-logo').src = './img/light.png';
            document.getElementById('navbar').classList.remove('bg-dark');
            document.getElementById('navbar').classList.add('bg-light');
        }
    }
}

function setLight(){

}

function setDark(){
    document.documentElement.setAttribute('data-bs-theme', 'dark');
    document.body.classList.remove('bg-light');
    document.body.classList.add('bg-dark');
    document.getElementById('jecna-logo').classList.add('inverted-logo');
    document.getElementById('mojerande-logo').src = './img/dark.png';
    document.getElementById('navbar').classList.remove('bg-light');
    document.getElementById('navbar').classList.add('bg-dark');
}


const themes = ['theme-dark', 'theme-light', 'theme-device'];

// Function to cycle through themes: dark mode, light mode, and device's preference
function cycleThemes() {
    const currentTheme = localStorage.getItem('theme');
    let nextThemeIndex = (themes.indexOf(currentTheme) + 1) % themes.length;
    let nextTheme = themes[nextThemeIndex];
    setTheme(nextTheme);
}


// Immediately invoked function to set the theme on initial load
(function () {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        setTheme(savedTheme);
    } else {
        // Set the theme based on device preference
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDarkMode) {
            setTheme('theme-dark');
        } else {
            setTheme('theme-light');
        }
    }
})();