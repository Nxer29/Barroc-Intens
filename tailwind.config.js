import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#212121',
                accent: '#FDD716',
                background: '#FFFFFF',
            },
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
                display: ['"Big Shoulders Display"', 'sans-serif'],
            },
            borderRadius: {
                xl: '1rem',
                '2xl': '1.5rem',
            },
        },
    },

    plugins: [forms],
};

