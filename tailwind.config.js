const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [
      './resources/**/*.vue',
      './resources/**/*.blade.php',
      './.used_colors'
  ],
  theme: {
    extend: {
        colors: {
            red: {
                ...colors.red,
                '700': '#ff0000'
            }
        }
    },
  },
  variants: {
      borderWidth: ['responsive', 'first', 'hover', 'focus'],
      backgroundColor: ['odd']
  },
  plugins: [],
}
