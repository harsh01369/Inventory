document.addEventListener('DOMContentLoaded', function() {
    var languageSwitcher = document.getElementById('languageSwitcher');

    function translatePage(language) {
    console.log("Translating to:", language); // Debug log
    fetch(language + '.json')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('[data-translate]').forEach(el => {
                var key = el.getAttribute('data-translate');
                el.textContent = data[key] || "Key not found: " + key;
            });
        }).catch(error => console.error("Translation failed:", error));
	}


    languageSwitcher.addEventListener('change', function() {
        var selectedLanguage = this.value;
        translatePage(selectedLanguage);
    });

    // Optional: Detect the user's browser language and set the dropdown accordingly
    var userLang = navigator.language || navigator.userLanguage;
    if (userLang.startsWith('fr')) {
        languageSwitcher.value = 'fr';
        translatePage('fr');
    } else if (userLang.startsWith('es')) {
        languageSwitcher.value = 'es';
        translatePage('es');
    } else {
        languageSwitcher.value = 'en';
        translatePage('en');
    }
});

