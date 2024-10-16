import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import scrollbar from 'tailwind-scrollbar';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/*.js.php",
        "./resources/views/**/*.vue.php",
    ],
    presets: [
        "./vendor/wireui/wireui/tailwind.config.js",
        "./vendor/power-components/livewire-powergrid/tailwind.config.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'alert-show': 'showAlert 1s ease forwards',
                'alert-hide': 'hideAlert 1s ease forwards',
            },
            keyframes: {
                showAlert: {
                    '0%': { transform: 'translateX(100%)' },
                    '40%': { transform: 'translateX(-10%)' },
                    '80%': { transform: 'translateX(0%)' },
                    '100%': { transform: 'translateX(-10px)' },
                },
                hideAlert: {
                    '0%': { transform: 'translateX(-10px)' },
                    '40%': { transform: 'translateX(0%)' },
                    '80%': { transform: 'translateX(-10%)' },
                    '100%': { transform: 'translateX(100%)' },
                },
            },
            colors: {
                Primary: "#434955",
                'custom-red': '#5BB318',
                'custom-red-dark': '#BA2C2C',
                'custom-dark-green': '#FF1700',
                'custom-green': '#2B7A0B',
                'custom-yellow': '#FFBF00',
                'iroad-green': '#6AA76F',
                'iroad-orange': '#FF9100',
                'custom-green-light': 'rgba(163, 214, 163, 0.5)'
            },
            fontSize: {
                xxs: [
                    "10px",
                    {
                        lineHeight: "1.2", // Adjust based on your preference
                        letterSpacing: "0.02em", // Adjust based on your preference
                    },
                ],
            },
        },
    },

    plugins: [
        require('tailwind-scrollbar'),
        // other plugins
      ],
};
