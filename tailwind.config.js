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
                    50: '#EBE9F0',
                    100: '#C1BBD0',
                    200: '#A39AB9',
                    300: '#796C98',
                    400: '#5F5085',
                    500: '#372466',
                    600: '#32215D',
                    700: '#271A48',
                    800: '#1E1438',
                    900: '#170F2B',
                },

                secondary: {
                    50: '#F4F0FF',
                    100: '#DED0FF',
                    200: '#CEBAFF',
                    300: '#B89AFF',
                    400: '#AA86FF',
                    500: '#9568FF',
                    600: '#885FE8',
                    700: '#6A4AB5',
                    800: '#52398C',
                    900: '#3F2C6B',
                },

                neutral: {
                    50: '#F5F5F5',
                    100: '#DEDEDE',
                    200: '#CFCFCF',
                    300: '#B9B9B9',
                    400: '#ABABAB',
                    500: '#969696',
                    600: '#898989',
                    700: '#6B6B6B',
                    800: '#535353',
                    900: '#3F3F3F',
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
