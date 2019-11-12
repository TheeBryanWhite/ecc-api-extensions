<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://eastcoastcatalyst.com
 * @since             1.0.0
 * @package           ECC_API_Extensions
 *
 * @wordpress-plugin
 * Plugin Name:       ECC REST API Extensions
 * Description:       This plugin extends the default WordPres REST API
 * Version:           1.0.0
 * Author:            Bryan White
 * Author URI:        http://eastcoastcatalyst.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ecc-api-extensions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class all_terms {

    public function __construct() {

        $version = '2';
        $namespace = 'wp/v' . $version;
        $base = 'all-terms';

        register_rest_route($namespace, '/' . $base, array(
            'methods' => 'GET',
            'callback' => array($this, 'get_all_terms'),
        ));

    }

    public function get_all_terms($object) {

        $return = array();

        // Get taxonomies
        $args = array(
            'public' => true,
            '_builtin' => false
        );

        $output = 'names';
        $operator = 'and';
        $taxonomies = get_taxonomies($args, $output, $operator);

        foreach ($taxonomies as $key => $taxonomy_name) {
            if($taxonomy_name = $_GET['term']){
                $return = get_terms($taxonomy_name);
            }
        }

        return new WP_REST_Response($return, 200);

    }
    
}

add_action('rest_api_init', function () {
    $all_terms = new all_terms;
});
