const currentPage = document.querySelector('main');
const currentURL = window.location.pathname;

// Si estamos en la pagina de Contact, agregaremos la siguiente clase al main
if (currentURL === '/contact/'){
	currentPage.classList.add('contact-bg');
}

// Si estamos en la pagina de About
if (currentURL === '/who-we-are/'){
	currentPage.classList.add('about-bg');
}