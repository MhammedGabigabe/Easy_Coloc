import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // On garde Figtree, elle est très proche de celle de l'image
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'easy-dark': '#0f172a',      // Fond très sombre
                'easy-blue': '#4a90e2',      // Le bleu du logo "Easy"
                'easy-bg-card': '#1e293b',   // Fond des formulaires
                'easy-teal': '#2dd4bf',      // Pour les accents (comme sur l'app mobile)
            },
            letterSpacing: {
                'ultra-wide': '.25em',       // Pour le slogan "VIVRE ENSEMBLE..."
            }
        },
    },

    plugins: [forms],
};