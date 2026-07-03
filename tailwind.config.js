/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./*.php",
        "./includes/**/*.php",
        "./admin/**/*.php",
        "./js/**/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                outfit: ['Outfit', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace']
            },
            colors: {
                brand: {
                    green: '#22c55e',
                    bg: '#0a0a0f',
                    bg2: '#0d0d14',
                    bg3: '#111118',
                    text: '#f0f0f4',
                    muted: 'rgba(240, 240, 244, 0.60)',
                }
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            }
        }
    },
    plugins: []
}
