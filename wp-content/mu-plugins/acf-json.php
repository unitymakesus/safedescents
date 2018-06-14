<?php
/*
Plugin Name: ACF Local JSON plugin
Plugin URI:
Author: Unity
Version: 0.1
*/

add_filter('acf/settings/save_json', function ($path) {
    return dirname(__FILE__) . '/acf-json';
});
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = dirname(__FILE__) . '/acf-json';
    return $paths;
});
