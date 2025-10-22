import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.{html,js,php,vue,blade.php}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                inter: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                comfortaa: ["Comfortaa", "cursive"],
                fredoka: ["Fredoka", "sans-serif"],
                dmsans: ["DM Sans", "sans-serif"],
            },
            colors: {
                nav: "#C7D4CE", // your color
                "sina-blue": "#46798E",
            },
        },
    },

    plugins: [forms],
};
