/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./pages/**/*.{php,js}",
    "./*.php",
    "./js/**/*.js"
  ],
  theme: {
    extend: {
      gridTemplateColumns: {
        'golden': '1fr 1.618fr',
        'golden-reverse': '1.618fr 1fr',
      },
      aspectRatio: {
        'golden': '1.618',
      },
      spacing: {
        'golden-sm': '0.618rem',
        'golden': '1.618rem',
        'golden-lg': '2.618rem',
        'golden-xl': '4.236rem',
      },
    },
  },
  plugins: [
    require('tailwindcss-golden-ratio'),
  ],
} 