/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin');
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.css",
  ],
  theme: {
    extend: {
      colors:{
        'colorFondo': '#613C4C',
        'colorCabera':'#2B2C30',
        'colorCaberaTras':'rgba(43,44,48,0.5)',
        'colorCaberaTras2':'rgba(43,44,48,0.9)',
        'colorMain': '#453745',
        'colorLetra':'white',
        'colorLetraTras':'rgba(255, 255, 255, 0.6)',
        'colorLetraOscura':'black',
        'colorDetalles': '#BF1B4B',
        'colorDetallesTras': 'rgba(191, 27, 75, 0.70)',
        'colorComplem': '#4465B8',
        'colorBarra2':'#541530',
        'colorSecundario':'#0b191f',
      },
      screens: {
        'xsm':'70px',
      }
    },
  },
  plugins: [
    function ({ addVariant }) {
      // todos los hijos directos
      addVariant('all-button', '& > button');
      addVariant('all-div','& > div');
      addVariant('all-span','& > span');
      addVariant('all-p','& > p');
      addVariant('all-ul','& > ul');
      addVariant('all-li','& > li');
      addVariant('all-input','& > input ');
      addVariant('all-label','& > label');
      addVariant('all-tr','& > tr');
      addVariant('all-td','& > td');
      addVariant('all','& > *');
      
      
      // todos los hijos incluso no directos
      addVariant('all-all-button', '&  button');
      addVariant('all-all-div','&  div');
      addVariant('all-all-span','&  span');
      addVariant('all-all-p','&  p');
      addVariant('all-all-ul','&  ul');
      addVariant('all-all-li','&  li');
      addVariant('all-all-input','&  input ');
      addVariant('all-all-label','&  label');
      addVariant('all-all','&  *');
    },
  ],
}

