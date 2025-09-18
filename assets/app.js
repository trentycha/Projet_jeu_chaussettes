import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

// Import de la font pour Webpack Encore
import './font/baby-gemoy/Baby_Gemoy.ttf';
import './font/moldie-demo/Moldie_Demo.otf';

document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("chaussettes");
    if (!container) return;

    const nbrChaussettes = 200;
    const imagePath = container.dataset.image;
    const specialPath = container.dataset.special;

    for (let i = 0; i < nbrChaussettes; i++) {
        const img = document.createElement("img");
        img.src = imagePath;

        const size = 50 + Math.random() * 100;
        img.style.width = `${size}px`;
        img.style.height = 'auto';

        img.style.position = 'absolute';
        img.style.left = `${Math.random() * (container.clientWidth - size)}px`;
        img.style.top = `${Math.random() * (container.clientHeight - size)}px`;

        const rotation = Math.random() * 360;
        img.style.transform = `rotate(${rotation}deg)`;

        container.appendChild(img);
    }

    const specialImg = document.createElement("img");
    specialImg.src = specialPath;

    const sizeSpecial = 50 + Math.random() * 100;
    specialImg.style.width = `${sizeSpecial}px`;
    specialImg.style.height = 'auto';

    specialImg.style.position = 'absolute';
    specialImg.style.left = `${Math.random() * (container.clientWidth - sizeSpecial)}px`;
    specialImg.style.top = `${Math.random() * (container.clientHeight - sizeSpecial)}px`;

    const rotationSpecial = Math.random() * 360;
    specialImg.style.transform = `rotate(${rotationSpecial}deg)`;

    container.appendChild(specialImg);
});
