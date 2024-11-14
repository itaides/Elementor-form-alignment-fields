<?php
/**
 * Plugin Name: Elementor Form Text Alignment
 * Description: Adds text alignment options to Elementor form fields
 * Version: 1.0.0
 * Author: Itai Ben Zeev
 * Author URI: https://github.com/itaibenzeev
 * License: GPL v2 or later
 * Text Domain: elementor-form-alignment
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package ElementorFormAlignment
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('EFA_VERSION', '1.0.0');
define('EFA_FILE', __FILE__);
define('EFA_PATH', plugin_dir_path(EFA_FILE));
define('EFA_URL', plugin_dir_url(EFA_FILE));

// Load core files
require_once EFA_PATH . 'includes/class-plugin.php';
require_once EFA_PATH . 'includes/class-requirements.php';
require_once EFA_PATH . 'includes/class-form-alignment.php';

/**
 * Initialize plugin
 */
function efa_init() {
    ElementorFormAlignment\Plugin::instance();
}

add_action('plugins_loaded', 'efa_init');