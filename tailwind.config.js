/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: 'rgb(var(--clr-primary) / <alpha-value>)',
        secondary: 'rgb(var(--clr-secondary) / <alpha-value>)',
      },
      fontFamily: {
        poppins: ['Poppins', 'serif'],
      },
    },
  },
  plugins: [],
}

