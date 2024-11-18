const translations = {
    es: {
        title: "InfoUni",
        heading: "Toda la información sobre Universidades a tu alcance",
        objetivo: "¿Cuál es nuestro objetivo?",
        textoObjetivo: "Nuestro objetivo es centralizar toda la información de universidades españolas, haciendo que sea más accesible y fácil de encontrar.",
        elegirnos: "¿Por qué elegirnos?",
        textoElegirnos: "Por nuestra rapidez. Toda la información que necesites la obtendrás más rápido desde nuestro portal.",
        footerText: "Contacta con nosotros ➜ Teléfono: 633 78 80 85 // Correo electrónico: InfoUni@hotmail.com",
        footerLink: "Haznos una consulta",
        images: {
            universidad: "img/universidad.png",
            centro: "img/centro.png",
            titulo: "img/titulo.png"
        },
        nav: {
            universidades: "Universidades",
            centros: "Centros",
            titulos: "Títulos"
        }
    },
    en: {
        title: "InfoUni",
        heading: "All the information about Universities at your fingertips",
        objetivo: "What is our goal?",
        textoObjetivo: "Our goal is to centralize all information on Spanish universities, making it more accessible and easier to find.",
        elegirnos: "Why choose us?",
        textoElegirnos: "For our speed. All the information you need will be available faster through our portal.",
        footerText: "Contact us ➜ Phone: 633 78 80 85 // Email: InfoUni@hotmail.com",
        footerLink: "Make an inquiry",
        images: {
            universidad: "img/universidad-en.png",
            centro: "img/centro-en.png",
            titulo: "img/titulo-en.png"
        },
        nav: {
            universidades: "Universities",
            centros: "Colleges",
            titulos: "Degrees"
        }
    },
    fr: {
        title: "InfoUni",
        heading: "Toutes les informations sur les Universités à portée de main",
        objetivo: "Quel est notre objectif ?",
        textoObjetivo: "Notre objectif est de centraliser toutes les informations sur les universités espagnoles, pour les rendre plus accessibles et faciles à trouver.",
        elegirnos: "Pourquoi nous choisir ?",
        textoElegirnos: "Pour notre rapidité. Toutes les informations dont vous avez besoin seront disponibles plus rapidement depuis notre portail.",
        footerText: "Contactez-nous ➜ Téléphone : 633 78 80 85 // Courriel : InfoUni@hotmail.com",
        footerLink: "Faites une demande",
        images: {
            universidad: "img/universidad-fr.png",
            centro: "img/centro-fr.png",
            titulo: "img/titulo-fr.png"
        },
        nav: {
            universidades: "Universités",
            centros: "Centres",
            titulos: "Diplômes"
        }
    }
};


function changeLanguage() {
    const language = document.getElementById("language").value;
    const texts = translations[language];

    // Cambia el texto de la navegación
    document.querySelector("#universidades-link").textContent = texts.nav.universidades;
    document.querySelector("#centros-link").textContent = texts.nav.centros;
    document.querySelector("#titulos-link").textContent = texts.nav.titulos;

    // Cambia el contenido de los elementos principales
    document.title = texts.title;
    document.querySelector(".main-heading").textContent = texts.heading;
    document.querySelector(".objetivo").textContent = texts.objetivo;
    document.querySelector(".textoObjetivo").textContent = texts.textoObjetivo;
    document.querySelector(".elegirnos").textContent = texts.elegirnos;
    document.querySelector(".textoElegirnos").textContent = texts.textoElegirnos;

    // Cambia el texto del footer
    document.querySelector(".footer-text").textContent = texts.footerText;
    document.querySelector(".footer-link").textContent = texts.footerLink;

    // Cambia las imágenes
    document.querySelector("#universidad-img").src = texts.images.universidad;
    document.querySelector("#centro-img").src = texts.images.centro;
    document.querySelector("#titulo-img").src = texts.images.titulo;
}
