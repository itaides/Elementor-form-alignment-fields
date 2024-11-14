<?php
namespace ElementorFormAlignment;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin requirements checker
 */
class Requirements {
    /**
     * Check if all requirements are met
     *
     * @return bool
     */
    public function check() {
        if (!$this->check_php_version()) {
            add_action('admin_notices', [$this, 'php_version_notice']);
            return false;
        }

        if (!$this->check_elementor_version()) {
            add_action('admin_notices', [$this, 'elementor_version_notice']);
            return false;
        }

        return true;
    }

    /**
     * Check PHP version
     *
     * @return bool
     */
    private function check_php_version() {
        return version_compare(PHP_VERSION, '7.4', '>=');
    }

    /**
     * Check Elementor version
     *
     * @return bool
     */
    private function check_elementor_version() {
        if (!defined('ELEMENTOR_VERSION')) {
            return false;
        }

        return version_compare(ELEMENTOR_VERSION, '3.5.0', '>=');
    }

    /**
     * PHP version notice
     */
    public function php_version_notice() {
        $message = sprintf(
            esc_html__('Elementor Form Text Alignment requires PHP version %s+. Your current PHP version is %s.', 'elementor-form-alignment'),
            '7.4',
            PHP_VERSION
        );
        
        printf('<div class="notice notice-error"><p>%s</p></div>', $message);
    }

    /**
     * Elementor version notice
     */
    public function elementor_version_notice() {
        if (!defined('ELEMENTOR_VERSION')) {
            $message = esc_html__('Elementor Form Text Alignment requires Elementor to be installed and activated.', 'elementor-form-alignment');
        } else {
            $message = sprintf(
                esc_html__('Elementor Form Text Alignment requires Elementor version %s+. Your current version is %s.', 'elementor-form-alignment'),
                '3.5.0',
                ELEMENTOR_VERSION
            );
        }

        printf('<div class="notice notice-error"><p>%s</p></div>', $message);
    }
}