/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: 'jit',
  content: [
    './views/**/*.php',
    './components/**/*.php',
    './widgets/**/*.php',
    './layouts/**/*.php',
  ],
  theme: {
    extend: {
      boxShadow: {
        primary: 'rgba(100, 100, 111, 0.2) 0px 7px 29px 0px',
      },
    },
  },
  plugins: [],
};
