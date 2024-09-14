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
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                Primary: "#434955",
                'custom-red': '#FF0000',
                'custom-red-dark': '#BA2C2C',
                'custom-green': '#00712D',
                'custom-yellow': '#FF9100',
                'iroad-green': '#6AA76F',
                'iroad-orange': '#F8A15E',
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
