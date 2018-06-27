// import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import coverage from './routes/coverageMap';

// Web Font Loader
var WebFont = require('webfontloader');
WebFont.load({
 google: {
   families: ['Lora:400,400i,700', 'Montserrat:300,400,400i,500,900', 'Muli'],
 },
});

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Coverage page
  coverage,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
