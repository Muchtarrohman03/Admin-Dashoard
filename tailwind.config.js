import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    themes: ["light", "dark", "cupcake"],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")[
                        "[data-theme=light]"
                    ],
                    primary: "#2563eb",
                    secondary: "#0f172a",
                    accent: "#e2e8f0",
                    neutral: "#e5e5e5",
                    error: "#dc2626",
                    warning: "#facc15",
                },
                dark: {
                    ...require("daisyui/src/theming/themes")[
                        "[data-theme=dark]"
                    ],
                    primary: "#2563eb",
                    secondary: "#e2e8f0",
                    accent: "#020617",
                    neutral: "#171717",
                    error: "#dc2626",
                    warning: "#facc15",
                },
            },
        ],
    },
};
