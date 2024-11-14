<?php
namespace ElementorFormAlignment;

use Elementor\Plugin;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Form Alignment component
 */
class FormAlignment {
    /**
     * Allowed field types for alignment control
     */
    public $allowed_fields = [
        'text',
        'email',
        'url',
        'password',
        'textarea',
        'tel',
        'number',
    ];

    /**
     * Constructor
     */
    public function __construct() {
        // Add text alignment class attribute to form field render
        add_filter('elementor_pro/forms/render/item', [$this, 'apply_text_alignment_class_to_field'], 10, 3);

        // Add text alignment control to form fields in Advanced tab
        add_action('elementor/element/form/section_form_fields/before_section_end', [$this, 'add_alignment_control_field'], 100, 2);

        // Add custom CSS for alignment classes to the footer
        add_action('wp_footer', [$this, 'add_alignment_styles_to_footer']);
    }

    /**
     * Add alignment control to each form field in the Advanced tab
     * 
     * @param \Elementor\Widget_Base $element
     * @param array $args
     */
    public function add_alignment_control_field($element, $args) {
        $elementor = Plugin::instance();
        $control_data = $elementor->controls_manager->get_control_from_stack($element->get_name(), 'form_fields');

        if (is_wp_error($control_data)) {
            return;
        }

        // Create a new repeater field for the alignment control
        $repeater = new Repeater();
        $repeater->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Align', 'form-alignment-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'form-alignment-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'form-alignment-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'form-alignment-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'inner_tab' => 'form_fields_advanced_tab',
                'tab' => 'content',
                'tabs_wrapper' => 'form_fields_tabs',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => $this->allowed_fields,
                        ],
                    ],
                ],
            ]
        );

        // Insert the new alignment control before the field ID control in the Advanced tab
        $new_control = $repeater->get_controls();
        $alignment_control = $new_control['text_align'];

        $new_fields = [];
        foreach ($control_data['fields'] as $key => $field) {
            if ('custom_id' === $field['name']) {
                $new_fields['text_align'] = $alignment_control;
            }
            $new_fields[$key] = $field;
        }
        $control_data['fields'] = $new_fields;

        $element->update_control('form_fields', $control_data);
    }

    /**
     * Apply the selected alignment class to the form field wrapper
     *
     * @param array $field Current field settings
     * @param int $field_index Current field index
     * @param \Elementor\Widget_Base $form_widget Current widget instance
     * @return array Modified field settings with alignment class applied
     */
    public function apply_text_alignment_class_to_field($field, $field_index, $form_widget) {
        // Check if alignment is set and the field type is allowed
        if (!empty($field['text_align']) && in_array($field['field_type'], $this->allowed_fields)) {
            // Add the alignment class based on the selected alignment
            $form_widget->add_render_attribute('input' . $field_index, 'class', 'align-' . $field['text_align']);
        }

        return $field;
    }

    /**
     * Output custom CSS for text alignment classes in the footer
     */
    public function add_alignment_styles_to_footer() {
        echo '<style>
        .align-right{
        text-align: right;
        }
        .align-center { 
        text-align: center; 
        }
        .align-left {
        text-align: left;
        }
        </style>';
    }
}

// Instantiate the FormAlignment class
new FormAlignment();
