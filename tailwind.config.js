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
        colors: {
            bluelog: '#22548b',
            yellowlog: '#FFAE00'
        },
    },
    plugins: [
        require("daisyui"),
    ],
    daisyui: {
        themes: ["corporate", "business"]
    },
    darkMode: ['class', '[data-theme="business"]']
}