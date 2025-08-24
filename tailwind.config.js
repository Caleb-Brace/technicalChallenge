const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/vue/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        cyan: colors.cyan,
        lime: colors.lime,
        purple: colors.purple,
        gray: colors.gray,
        slate: colors.slate,
        green: colors.green,
        red: colors.red,
      },
    },
  },
  safelist: [
    {
      pattern: /^(bg|text|border|hover:bg|hover:text|hover:border|shadow|rounded|p|px|py|m|mx|my|flex|grid|items|justify|gap|space|line-through|underline|opacity|min-h|max-h|min-w|max-w|w|h|z|leading|font)-/,
    },
  ],
  plugins: [],
};