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
                sans: ['Inter', 'Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#fff1f2',
                    100: '#ffe4e6',
                    200: '#fecdd3',
                    300: '#fda4af',
                    400: '#fb7185',
                    500: '#f43f5e',
                    600: '#e11d48',
                    700: '#be123c',
                    800: '#9f1239',
                    900: '#881337',
                    950: '#4c0519',
                },
            },
            animation: {
                'float':        'float 6s ease-in-out infinite',
                'float-delay':  'float 8s ease-in-out 2s infinite',
                'float-slow':   'float 10s ease-in-out 4s infinite',
                'shimmer':      'shimmer 2.5s linear infinite',
                'fade-in-up':   'fadeInUp 0.6s ease forwards',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px) scale(1)' },
                    '50%':      { transform: 'translateY(-20px) scale(1.04)' },
                },
                shimmer: {
                    '0%':   { backgroundPosition: '-200% center' },
                    '100%': { backgroundPosition:  '200% center' },
                },
                fadeInUp: {
                    '0%':   { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },

    plugins: [forms],
};
