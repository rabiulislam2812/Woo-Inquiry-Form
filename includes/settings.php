<?php
class Settings {
    public function __construct() {
        add_action('init', [$this, 'init']);
    }

    function init() {

        // Add settings tab hook
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);
        add_action('woocommerce_settings_tabs_enquiry_form', array($this, 'settings_tab_content'));
        add_action('woocommerce_update_options_enquiry_form', array($this, 'update_settings'));

    }

    // Add settings tab
    public function add_settings_tab($settings_tabs) {
        $settings_tabs['enquiry_form'] = 'Enquiry Form Settings';
        return $settings_tabs;
    }

    // Add settings fields
    public function settings_tab_content() {
        woocommerce_admin_fields($this->get_settings());
    }

    // Save settings
    public function update_settings() {
        woocommerce_update_options($this->get_settings());
    }

    // Get settings fields
    public function get_settings() {
        $settings = array(
            'section_title' => array(
                'name' => 'Enquiry Form Settings',
                'type' => 'title',
                'desc' => '',
                'id' => 'wc_enquiry_form_settings'
            ),
            'show_form' => array(
                'name' => 'Show Enquiry Form',
                'type' => 'checkbox',
                'desc' => 'Enable to show the enquiry form on product page.',
                'id' => 'wc_show_enquiry_form',
                'default' => 'yes'
            ),
            'form_shortcode' => array(
                'name' => 'Enquiry Form Shortcode',
                'type' => 'text',
                'desc' => 'Enter the shortcode for the contact form to use.',
                'id' => 'wc_enquiry_form_shortcode'
            ),
            'text' => array(
                'name' => 'Enquiry Button Text',
                'type' => 'text',
                'desc' => 'Type Button Text.',
                'id' => 'wc_enquiry_btn_text',
                'default' => 'Enquire about this product'
            ),
            'hide_product_image' => array(
                'name' => 'Hide Product Image',
                'type' => 'checkbox',
                'desc' => 'Enable to hide the product image on product page.',
                'id' => 'wc_hide_product_image',
                'default' => 'no'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_enquiry_form_settings'
            )
        );
        return $settings;
    }

}