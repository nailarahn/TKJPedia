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

            colors: {
                primary: {
                    50: '#FFF3E6',
                    100: '#FFE0BF',
                    200: '#FFD199',
                    300: '#FFB366',
                    400: '#FF9933',
                    500: '#FF8100',
                    600: '#FF6A00',
                    700: '#FF4D00',
                    800: '#E64500',
                    900: '#CC3300',
                },

                secondary: {
                    50: '#FFF0EB',
                    100: '#FFD6CC',
                    200: '#FFB8A3',
                    300: '#FF9470',
                    400: '#FF7040',
                    500: '#FF4D00',
                    600: '#FF3300',
                    700: '#E62E00',
                    800: '#CC2900',
                    900: '#991F00',
                },

                neutral: {
                    50: '#F8F8F8',
                    100: '#EAEAEA',
                    200: '#DADADA',
                    300: '#C7C7C7',
                    400: '#B5B5B5',
                    500: '#9E9E9E',
                    600: '#7A7A7A',
                    700: '#5C5C5C',
                    800: '#404040',
                    900: '#2A2A2A',
                }
            },
            fontFamily: {
                sans: ['Poppins'],
            },

            boxShadow: {
                sm: '0 2px 4px rgba(0,0,0,0.05)',
                md: '0 6px 12px rgba(0,0,0,0.08)',
                lg: '0 10px 30px rgba(0,0,0,0.10)',
                xl: '0 20px 40px rgba(0,0,0,0.12)',
            },
        },

    },

    plugins: [forms],
};
