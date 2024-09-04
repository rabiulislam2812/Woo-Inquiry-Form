<?php
/*
Plugin Name: Woo Inquiry Form
Description: Adds an enquiry form to WooCommerce single product page.
Version: 1.0
Author: Rabiul Islam
Author URI: //rabiulislam.net
Text Domain: devweb-inq
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('ProductEnquiryPlugin')) {
    class WC_Product_Enquiry {
        protected $settings;

        public function __construct() {

            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
            add_action('woocommerce_before_add_to_cart_form', array($this, 'add_enquiry_button'), 20);
            add_action('wp_footer', array($this, 'add_enquiry_form_modal'));

            if (!class_exists('Settings')) {
                require plugin_dir_path(__FILE__) . 'includes/settings.php';
            }

            $this->settings = new Settings(); // Initialize Settings class
        }

        // Enqueue plugin essential scripts
        public function enqueue_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_style('product-enquiry-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_script('product-enquiry-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
        }

        // Inquiry form button
        public function add_enquiry_button() {
            $show_enquiry_form = get_option('wc_show_enquiry_form', 'yes');
            $form_btn_text = get_option('wc_enquiry_btn_text');
            if ($show_enquiry_form == 'yes') {
                echo '<div class="inq-button"><button id="enquiry-toggle" class="button">' . esc_html($form_btn_text) . '</button></div>';
            }
        }

        // Inquiry form Modal
        public function add_enquiry_form_modal() {
            if (is_product()) {
                global $product;
                $shortcode = get_option('wc_enquiry_form_shortcode', false);
                $hide_product_image = get_option('wc_hide_product_image', 'no');
                $product_image_url = wp_get_attachment_url($product->get_image_id());
                $product_title = $product->get_name();
                if ($shortcode == true) {
                    echo '<div id="enquiry-modal" class="modal">
                    <div class="modal-content">
                        <span class="devw-mod-close">&times;</span>';
                    echo '<div class="inq-wrap"><h2 class="inq-product-title">' . $product_title . '</h2>';
                    echo $hide_product_image == 'no' ? '<img id="enquiry-product-image" src="' . esc_url($product_image_url) . '" alt="' . esc_attr($product->get_name()) . '" />' : '';
                    echo '</div>';
                    echo do_shortcode($shortcode);
                    echo '  </div>
                  </div>';
                } else {
                    echo '<div id="enquiry-modal" class="modal">
                    <div class="modal-content">
                        <span class="devw-mod-close">&times;</span>';
                    echo '<div class="inq-wrap"> <p class="no-message">' . __("Enter a form shortcode Form Woocommerce->Settings->Enquiry Form Settings.", "devweb-inq") . '</p>';
                    echo '</div>';
                    echo '  </div>
                  </div>';
                }
            }
        }


    }

    new WC_Product_Enquiry();
}
