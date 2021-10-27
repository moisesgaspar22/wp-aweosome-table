<?php

/**
 * Plugin Name:       MG plugin test
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Moises Gaspar
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       mg-test-plugin
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('AWEOSOME_TABLE_DEFINED')) {
    define('AWEOSOME_TABLE_DEFINED', [
            'VERSION'     => '1.0.0',
            'PLUGIN_DIR'  => plugin_dir_path(__FILE__),
            'PLUGIN_URL'  => plugin_dir_url(__FILE__),
            'PLUGIN_FILE' => __FILE__
        ]
    );
}

require_once 'vendor/autoload.php';

(new MgTest\core\App())->init();
