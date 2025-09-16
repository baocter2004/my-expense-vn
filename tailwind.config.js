/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      borderRadius: {
        'custom-sides': '60px 0 60px 0',
      },
      keyframes: {
        swing: {
          '0%': { transform: 'rotate(-15deg)' },
          '50%': { transform: 'rotate(15deg)' },
          '100%': { transform: 'rotate(-15deg)' },
        },
        pull: {
          '0%': { transform: 'scaleY(1)' },
          '30%': { transform: 'scaleY(1.2) translateY(5px)' },
          '60%': { transform: 'scaleY(0.9) translateY(-3px)' },
          '100%': { transform: 'scaleY(1) translateY(0)' },
        },
      },
      animation: {
        swing: 'swing 3s ease-in-out infinite',
        pull: 'pull 0.6s cubic-bezier(.4,0,.2,1)',
      },
    },
  },
  plugins: [],
};