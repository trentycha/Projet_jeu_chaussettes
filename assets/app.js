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

    const imagePath = container.dataset.image;
    const img = document.createElement("img");
    img.src = imagePath;

    const size = 50 + Math.random() * 100;
    img.style.width = `${size}px`;
    img.style.height = 'auto';

    img.style.position = 'absolute';
    img.style.left = `${Math.random() * (container.clientWidth - size)}px`;
    img.style.top = `${Math.random() * (container.clientHeight - size)}px`;

    container.appendChild(img);
});
