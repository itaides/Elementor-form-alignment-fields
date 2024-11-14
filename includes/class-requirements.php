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
        /* translators: %1$s: Required PHP version, %2$s: Current PHP version */
        $message = sprintf(
            __('Form Text Alignment for Elementor requires PHP version %1$s+. Your current PHP version is %2$s.', 'form-alignment-elementor'),
            '7.4',
            PHP_VERSION
        );
        
        printf('<div class="notice notice-error"><p>%s</p></div>', wp_kses_post($message));
    }

    /**
     * Elementor version notice
     */
    public function elementor_version_notice() {
        if (!defined('ELEMENTOR_VERSION')) {
            $message = __('Form Text Alignment for Elementor requires Elementor to be installed and activated.', 'form-alignment-elementor');
        } else {
            /* translators: %1$s: Required Elementor version, %2$s: Current Elementor version */
            $message = sprintf(
                __('Form Text Alignment for Elementor requires Elementor version %1$s+. Your current version is %2$s.', 'form-alignment-elementor'),
                '3.5.0',
                ELEMENTOR_VERSION
            );
        }
    
        printf('<div class="notice notice-error"><p>%s</p></div>', wp_kses_post($message));
    }    
}