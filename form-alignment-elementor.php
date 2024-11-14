<?php
/**
 * Plugin Name: Form Text Alignment for Elementor
 * Plugin URI: https://github.com/itaides/form-alignment-elementor-fields
 * Description: Add text alignment controls to Elementor form fields.
 * Version: 1.0.0
 * Author: Itai Ben Zeev
 * Author URI: https://arctica.digital
 * Text Domain: form-alignment-elementor
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires PHP: 7.4
 * Requires at least: 5.0
 * Tested up to: 6.7
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