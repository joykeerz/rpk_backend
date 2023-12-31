/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/**/**/*.blade.php",
        "./resources/**/**/**/*.blade.php"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("daisyui"),
    ],
    daisyui: {
        themes: ['light']
    },
}
