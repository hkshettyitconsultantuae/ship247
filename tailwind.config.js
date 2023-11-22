const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        screens: {
            'sm': '576px',
            // => @media (min-width: 640px) { ... }

            'md': '768px',
            // => @media (min-width: 768px) { ... }

            'lg': '991px',
            // => @media (min-width: 991px) { ... }

            'xl': '1024px',
            // => @media (min-width: 1024px) { ... }

            '2xl': '1280px',
            // => @media (min-width: 1280px) { ... }

            '3xl': '1400px',
            // => @media (min-width: 1400px) { ... }

            '4xl': '1600px',
            // => @media (min-width: 1600px) { ... }
          },
        extend: {
            fontFamily: {
                sans: ['"Gotham_Regular"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
