<?php
namespace ElementorFormAlignment;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class
 */
class Plugin {
    /**
     * Plugin instance
     *
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Get plugin instance
     *
     * @return Plugin
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        $this->init();
    }

    /**
     * Initialize plugin
     */
    private function init() {
        // Check requirements
        $requirements = new Requirements();
        if (!$requirements->check()) {
            return;
        }

        // Initialize the form alignment component
        new FormAlignment();

        // Load text domain
        add_action('init', [$this, 'load_textdomain']);
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'elementor-form-alignment',
            false,
            dirname(plugin_basename(EFA_FILE)) . '/languages'
        );
    }

    /**
     * Show admin notice when Elementor is not installed
     */
    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-form-alignment'),
            '<strong>' . esc_html__('Elementor Form Text Alignment', 'elementor-form-alignment') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementor-form-alignment') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
}