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
            'form-alignment-elementor',
            false,
            dirname(plugin_basename(EFA_FILE)) . '/languages'
        );
    }

    /**
     * Show admin notice when Elementor is not installed
     */
    public function admin_notice_missing_elementor() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification not required for this admin notice
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    
        /* translators: %1$s: Plugin name, %2$s: Required plugin name */
        $message = sprintf(
            esc_html__('%1$s requires %2$s to be installed and activated.', 'form-alignment-elementor'),
            '<strong>' . esc_html__('Form Text Alignment for Elementor', 'form-alignment-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'form-alignment-elementor') . '</strong>'
        );
    
        printf('<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post($message));
    }
}