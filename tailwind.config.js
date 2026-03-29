import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#64748B",
                    50: "#E4E7EC",
                    100: "#D8DDE3",
                    200: "#C0C8D2",
                    300: "#A9B3C1",
                    400: "#919EB0",
                    500: "#79899F",
                    600: "#64748B",
                    700: "#4D596A",
                    800: "#353E4A",
                    900: "#1E2229",
                    950: "#121519",
                },
                flamingo: {
                    DEFAULT: "#EF4444",
                    50: "#FDEDED",
                    100: "#FCDADA",
                    200: "#F9B5B5",
                    300: "#F58F8F",
                    400: "#F26A6A",
                    500: "#EF4444",
                    600: "#E71414",
                    700: "#B30F0F",
                    800: "#800B0B",
                    900: "#4C0707",
                    950: "#320404",
                },
                turquoise: {
                    DEFAULT: "#40E0D0",
                    50: "#DEFAF7",
                    100: "#CCF7F3",
                    200: "#A9F1EA",
                    300: "#86EBE1",
                    400: "#63E6D9",
                    500: "#40E0D0",
                    600: "#20C8B7",
                    700: "#19978B",
                    800: "#11675E",
                    900: "#093732",
                    950: "#051F1C",
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
