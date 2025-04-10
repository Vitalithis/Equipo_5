import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        colors: {
            // Colores base
            efore: "#F8F6F4",
            eprimary: "#3E0345",
            esecondary: "#8090BF",
            eaccent: "#F6E867",
            eaccent2: "#AEC68D",

            // Variaciones de efore
            "efore-100": "#F9F7F5", // Muy claro
            "efore-200": "#F0E9E3", // Claro
            "efore-300": "#E8D9C7", // Medio claro
            "efore-400": "#D0B39C", // Medio
            "efore-500": "#B88D71", // Original (base)
            "efore-600": "#9F6B47", // Oscuro
            "efore-700": "#7F492B", // Muy oscuro

            // Variaciones de eprimary
            "eprimary-100": "#6A145F",
            "eprimary-200": "#5B0D59",
            "eprimary-300": "#4D064F",
            "eprimary-400": "#40013F",
            "eprimary-500": "#3E0345", // Original
            "eprimary-600": "#32022F",
            "eprimary-700": "#26021A",

            // Variaciones de esecondary
            "esecondary-100": "#AAB8D9",
            "esecondary-200": "#92A1C7",
            "esecondary-300": "#7A8AAD",
            "esecondary-400": "#617396",
            "esecondary-500": "#8090BF", // Original
            "esecondary-600": "#63749B",
            "esecondary-700": "#4C5C7F",

            // Variaciones de eaccent
            "eaccent-100": "#F8F9A6",
            "eaccent-200": "#F8F87E",
            "eaccent-300": "#F8F656",
            "eaccent-400": "#F8F52E",
            "eaccent-500": "#F6E867", // Original
            "eaccent-600": "#E7D23D",
            "eaccent-700": "#CBBB28",

            // Variaciones de eaccent2
            "eaccent2-100": "#B2D7A7",
            "eaccent2-200": "#A3C98F",
            "eaccent2-300": "#94BA77",
            "eaccent2-400": "#85AB5F",
            "eaccent2-500": "#AEC68D", // Original
            "eaccent2-600": "#8E9E74",
            "eaccent2-700": "#70825C",
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
