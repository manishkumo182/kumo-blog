

const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    './404.php',
    './footer.php',
    './header.php',
    './index.php',
    './page.php',
    './single.php',
    './lib/**/*.php',
    './components/**/*.php',
    './src/js/**/*.js',
  
  './**/*.php',
  './components/**/*.php',
  './lib/**/*.php',
  './src/js/**/*.js',


  ],

  safelist: [
    'bg-primary',
    'bg-secondary',
    'bg-accent',
    'text-primary',
    'text-secondary',
    'text-accent',
  ],
  theme: {
    fontFamily: {
      roboto: ['"Roboto Mono"', 'monospace'],
    },

    screens: {
      xs: '370px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      '2xl': '1536px',
      '4k': '2560px',
    },

    extend: {
      colors: {
        primary: '#312f2f',
        accent: '#dd574e',
        secondary: '#c3454f',

        shade: {
          300: '#CACACE',
          400: '#4D4D4D',
          500: '#95959D',
          800: '#4D4D4D',
          900: '#262626',
          dark: '#3F3F3F',
          banner: '#0A0A0A',
        },
      },
    },
  },

  corePlugins: {
    container: false,
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/line-clamp'),
    require('@tailwindcss/container-queries'),
  ],
}
