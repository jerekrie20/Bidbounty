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
            'earth-green': '#83A720', // Primary green for buttons, icons, and highlights
            'sky-blue': '#A0C9C7',    // Primary blue for backgrounds and large areas
            'wheat-yellow': '#fbbf24', // Primary yellow for highlights and accents
            'soil-brown': '#78350f',   // Primary brown for text and headers

            // Complementary and harmonious colors
            'forest-green': '#4C9A2A', // Deeper green for borders and shadows
            'ocean-blue': '#69A1AC',   // Darker blue for secondary backgrounds and sections
            'sunflower-yellow': '#FFD700', // Brighter yellow for call-to-action buttons and highlights
            'terra-cotta': '#D2691E',  // Reddish-brown for emphasis and contrast elements

            // Neutral colors
            'cloud-white': '#F5F5F5',  // Soft white for backgrounds and clean spaces
            'stone-gray': '#8A8A8A',   // Neutral gray for text, borders, and icons

            // Additional accent colors
            'rust-orange': '#D35400',  // Orange for alerts, warnings, and attention-grabbing elements
            'midnight-blue': '#2C3E50', // Dark blue for footers, headers, and deep backgrounds
            'lavender-purple': '#B57EDC', // Light purple for gentle accents and calming sections
            'peach-pink': '#FFDAB9',   // Soft pink for subtle highlights and friendly UI elements
            'danger-red': '#FF0000',   // Red for errors, warnings, and critical alerts
        },


        fontFamily: {
            'header': ['Lato', 'sans-serif'], // Include Lato font
            'body': ['Roboto', 'sans-serif'], // Include Roboto font
        }
    },
  },
  plugins: [],
}

