import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

// Import de la font pour Webpack Encore
import "./font/baby-gemoy/Baby_Gemoy.ttf";
import "./font/moldie-demo/Moldie_Demo.otf";

// Chargement du jeu
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("chaussettes");
    if (!container) return;

    const gameOver = document.getElementById("gameover");

    const nbrChaussettes = 200;
    const faussesChaussettes = 5;
    const imagePath = container.dataset.image;
    const specialPath = container.dataset.special;
    const hoverPath = container.dataset.hover;
    const hoverFausse = container.dataset.hoverFausse;
    const padding = 50;

    //Chaussettes normales, de fond
    for (let i = 0; i < nbrChaussettes; i++) {
        const img = document.createElement("img");
        img.src = imagePath;

        const size = 50 + Math.random() * 100;
        img.style.width = `${size}px`;
        img.style.height = "auto";

        img.style.position = "absolute";
        img.style.left = `${Math.random() * (container.clientWidth - size)}px`;
        img.style.top = `${Math.random() * (container.clientHeight - size)}px`;

        const rotation = Math.random() * 360;
        img.style.transform = `rotate(${rotation}deg)`;

        container.appendChild(img);
    }

    // Chaussette à trouver
    const specialImg = document.createElement("img");
    specialImg.src = specialPath;
    specialImg.classList.add("special");

    const gagner = document.getElementById("endgame");

    const sizeSpecial = 50 + Math.random() * 100;
    specialImg.style.width = `${sizeSpecial}px`;
    specialImg.style.height = "auto";

    specialImg.style.position = "absolute";
    specialImg.style.left = `${
        Math.random() * (container.clientWidth - sizeSpecial)
    }px`;
    specialImg.style.top = `${
        Math.random() * (container.clientHeight - sizeSpecial)
    }px`;

    const rotationSpecial = Math.random() * 360;
    specialImg.style.transform = `rotate(${rotationSpecial}deg)`;

    //Hover chaussette à trouver
    specialImg.addEventListener("mouseenter", () => {
        specialImg.src = hoverPath;
        specialImg.style.cursor = "pointer";
    });

    specialImg.addEventListener("click", () => {
        gagner.style.display = "block";

            // Récupérer le temps du chrono
    const chronoText = document.getElementById("chrono").textContent; // ex: "12.34"

    // Remplir le champ 'time' du formulaire Symfony
    const timeField = document.getElementById("score_time"); 
    if (timeField) {
        timeField.value = parseFloat(chronoText);
    }

    // Afficher le temps dans l'écran de fin
    const timeElapsed = document.getElementById("time-elapsed");
    if (timeElapsed) {
        timeElapsed.textContent = `Votre temps : ${chronoText} secondes`;
    }
    });

    specialImg.addEventListener("mouseleave", () => {
        specialImg.src = specialPath;
    });

    container.appendChild(specialImg);

    // Chaussettes piégées
    for (let j = 0; j < faussesChaussettes; j++) {
        const img = document.createElement("img");
        img.src = imagePath;

        const size = 50 + Math.random() * 100;
        img.style.width = `${size}px`;
        img.style.height = "auto";

        img.style.position = "absolute";
        img.style.left = `${Math.random() * (container.clientWidth - size)}px`;
        img.style.top = `${Math.random() * (container.clientHeight - size)}px`;

        const rotation = Math.random() * 360;
        img.style.transform = `rotate(${rotation}deg)`;

        //Hover
        img.addEventListener("mouseenter", () => {
            img.src = hoverFausse;
            img.style.cursor = "pointer";
        });

        img.addEventListener("click", () => {
            gameOver.style.display = "block";
        });

        img.addEventListener("mouseleave", () => {
            img.src = imagePath;
        });

        container.appendChild(img);
    }

        const chrono = document.getElementById("chrono");
        if (!chrono) return;

        const startTime = Date.now(); // temps de départ en ms
        let running = true;

        function updateTimer() {
             if (!running) return;

            const elapsed = Date.now() - startTime; // ms écoulées
            const centi = Math.floor((elapsed % 1000) / 10);
            const secondes = Math.floor(elapsed / 1000);

            chrono.textContent = `${secondes}.${
                centi < 10 ? "0" : ""
            }${centi} s`;

            requestAnimationFrame(updateTimer); // mise à jour continue
        }

        updateTimer();

    specialImg.addEventListener("click", () => {
    running = false;      // arrête la boucle updateTimer
    gagner.style.display = "block";
    });
});


let recupBtnAjouter = document.getElementById("ajouterScore");
recupBtnAjouter.addEventListener("submit", () => {
    event.preventDefault();
    const url = recupBtnAjouter.dataset.url;
    window.location.href = url;
})