// import external dependencies
import 'jquery';
import 'jquery-validation/dist/jquery.validate.js';
import 'flatpickr/dist/flatpickr.js';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import coverage from './routes/coverageMap';
import buyNow from './routes/buyNow';
import cart from './routes/cart';

// Web Font Loader
var WebFont = require('webfontloader');
WebFont.load({
 google: {
   families: ['Merriweather:300,300i,400,400i,700,700i', 'Montserrat:300,400,400i,500,900', 'Muli'],
 },
});

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Coverage page
  coverage,
  // Buy Now page
  buyNow,
  // Cart page
  cart,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
