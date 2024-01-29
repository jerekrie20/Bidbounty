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
            'earth-green': '#83A720', // Replace with the exact green color code
            'sky-blue': '#A0C9C7',    // Replace with the exact blue color code
            'wheat-yellow': '#fbbf24', // Replace with the exact yellow color code
            'soil-brown': '#78350f',   // Replace with the exact brown color code
            // Add any other custom colors here
        },

        fontFamily: {
            'header': ['Lato', 'sans-serif'], // Include Lato font
            'body': ['Roboto', 'sans-serif'], // Include Roboto font
        }
    },
  },
  plugins: [],
}

